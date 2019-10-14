<?php
/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2019/7/22
 * Time: 14:42
 */

namespace App\Repository\Home;

use App\Repository\Scrm\ScrmMiRepository;
use App\Repository\Scrm\ScrmRepository;
use App\User;
use Illuminate\Http\Request;
use EasyWeChat\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AuthRepository
{
    /**
     * 小程序登陆
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/7/22
     * Time: 15:02
     * @param Request $request
     * @return array
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function login(Request $request,$data_wx)
    {
        $at = $request->all();
        $mobile = isset($at['mobile'])?$at['mobile']:'';
        $country = isset($at['country'])?$at['country']:'';
        $province = isset($at['province'])?$at['province']:'';
        $city = isset($at['city'])?$at['city']:'';

        $openid = $data_wx['openid'];
        $session_key = $data_wx['session_key'];
//        $openid = 23;
//        $session_key = 123;

        // 根据openid查询用户信息
        $member_data = User::where('xcx_openid',$openid)->first();
        if(!$member_data && $mobile)
        {
            try
            {
                // 保存用户信息
                $time = date('Y-m-d H:i:s');
                $member = new User();
                $member->name = $at['name'];
                $member->mobile = $mobile;
                $member->avatarurl = $at['avatarUrl'];
                $member->country = $country;
                $member->province = $province;
                $member->city = $city;
                $member->integral = 0;
                $member->tier = 1;
                $member->member_no = User::generateMemberNO();
                $member->xcx_openid = $openid;
                $member->save();

                // 新用户注册后scrm逻辑
                $this->scrm_regist($member->id);
            }
            catch (\Exception $exception)
            {
                return [
                    'token' => '',
                    'session_key' => ''
                ];
            }
        }
        else if($member_data)
        {
            $mobile = $member_data['mobile'];
        }
        // 返回用户token和session_key
        return [
            'token' => login_jwt($mobile),
            'session_key' => $session_key
        ];
    }

    /**
     * 新用户注册后scrm逻辑
     * 查询用户是否有用户-用户不存在，注册用户-注册成功-查询用户信息得到cid-根据cid变动积分
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/9/9
     * Time: 15:47
     * @param $id
     */
    public function scrm_regist($id)
    {
        $scrm = new ScrmRepository();
        $user = User::find($id);
        $is_member = $scrm->is_member($id);
        Log::info('$is_member:');
        Log::info(json_encode($is_member));
        // 不是新用户
        if($is_member != false && $is_member['code'] == 1 && $user)
        {
            // 注册用户
            $params = [];
            $params['openid'] = $user['xcx_openid'];
            $params['Mobile'] = $user['mobile'];
            $params['Userid'] = $user['xcx_openid'];

            $re_register = $scrm->register($params);

            Log::info('$re_register:');
            Log::info($re_register);
            // 注册成功
            if($re_register != false && (int)$re_register['code'] == 0)
            {
                // 获取用户信息
                $re_query_member = $scrm->query_member($id);

                Log::info('$re_query_member:');
                Log::info($re_query_member);


                if($re_query_member != false && isset($re_query_member['data']))
                {
                    $cId = $re_query_member['data']['id'];
                    // 赠送积分
                    $scrm_mi = new ScrmMiRepository();
                    $re_loyalty = $scrm_mi->loyalty($cId);


                    Log::info('$re_loyalty:');
                    Log::info($re_loyalty);
                }
            }
        }
    }

    /**
     * 微信手机号消息解密
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/7/22
     * Time: 15:10
     * @param Request $request
     * @param $data_wx
     * @return array|string
     * @throws \EasyWeChat\Kernel\Exceptions\DecryptException
     */
    public function decryptData(Request $request,$data_wx)
    {
        $encryptedData = $request->input('encryptedData','');
        $iv = $request->input('iv','');
        $session =  $data_wx['session_key'];
        $app = Factory::miniProgram(config('wechat.mini_program.default'));

        $data = $app->encryptor->decryptData($session, $iv, $encryptedData);

        if(isset($data['phoneNumber']))
        {
            return ['mobile'=>$data['phoneNumber'],'session_key' => $session];
        }
        return '';
    }

}