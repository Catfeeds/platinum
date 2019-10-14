<?php
/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2019/8/23
 * Time: 10:49
 */

namespace App\Repository\Ext;


use App\Models\Home\UserDetail;
use App\Repository\Home\User\UserRepository;
use App\User;
use Illuminate\Http\Request;

class ExtRepository
{
    /**
     * 获取用户信息
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/27
     * Time: 11:29
     * @param Request $request
     * @return mixed
     */
    public function get_user(Request $request)
    {
        $id = $request->input('id','');

        $user = [];
        $user['id'] = $id;
        $repository = new UserRepository();
        $data = $repository->userinfo($user);
        $data = $this->data_init($data);
        return $data;
    }

    /**
     * 数据初始化
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/27
     * Time: 11:29
     * @param $data
     * @return mixed
     */
    public function data_init($data)
    {
        // 数据处理
        if($data)
        {
            if($data->provinced)
            {
                $data->province = $data->provinced['name'];
                unset($data->provinced);
            }
            if($data->cityd)
            {
                $data->city = $data->cityd['name'];
                unset($data->cityd);
            }
            if($data->aread)
            {
                $data->area = $data->aread['name'];
                unset($data->aread);
            }
            // 手机号处理
            $mobile = $data['mobile'];
            $data['mobile'] = substr($mobile,0,3).'****'.substr($mobile,7,11);
        }
        return $data;
    }

    /**
     * 会员注册
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/27
     * Time: 13:34
     * @param Request $request
     * @return mixed
     */
    public function register(Request $request)
    {
        $name = $request->input('name','');                         // 姓名
        $mobile = $request->input('mobile','');                     // 手机号
        $avatarurl = $request->input('avatarurl','');               // 头像
        $get_info_by_sms = $request->input('get_info_by_sms',1);    // 是否愿意接受短信 1是 2否
        $country = $request->input('country','');                   // 国家
        $province = $request->input('province','');                 // 省
        $city = $request->input('city','');                         // 市
        $area = $request->input('area','');                         // 区
        $addr = $request->input('addr','');                         // 详细地址
        $zip = $request->input('zip','');                           // 邮编
        $email = $request->input('email','');                       // 邮箱
        $member_nickname = $request->input('member_nickname','');   // 会员昵称
        $source = $request->input('source','');                     // 来源

        $model = new User();
        $model->name = $name;
        $model->mobile = $mobile;
        $model->avatarurl = $avatarurl;
        $model->get_info_by_sms = $get_info_by_sms;
        $model->integral = 0;
        $model->member_no = User::generateMemberNO();
        $model->tier = 1;
        $model->password = 123;

        if($member_nickname) $model->member_nickname = $member_nickname;
        if($country) $model->country = $country;
        if($province) $model->province = $province;
        if($city) $model->city = $city;
        if($area) $model->area = $area;
        if($addr) $model->addr = $addr;
        if($zip) $model->zip = $zip;
        if($email) $model->email = $email;
        if($source) $model->source = $source;

        $model->save();
        $id = $model->id;

        if($id)
        {
            // 增送积分

        }

        // 用户详情保存
        $this->detail_add($request,$id);

        return $id;
    }


    /**
     * 用户详情保存
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/27
     * Time: 13:43
     * @param Request $request
     */
    public function detail_add(Request $request,$id)
    {
        $at = $request->all();

        $model_detail = new UserDetail();
        $model_detail->u_id = $id;

        foreach ($model_detail->getFillable() as $v)
        {
            if(isset($at[$v])) $model_detail->$v = $at[$v];
        }

        $model_detail->save();
    }

    /**
     * 修改用户基本信息
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/27
     * Time: 17:27
     * @param Request $request
     */
    public function user_up(Request $request)
    {
        $id = $request->input('id','');
        $at = $request->all();

        $update = [];
        if(isset($at['name'])) $update['name'] = $at['name'];
        if(isset($at['avatarurl'])) $update['avatarurl'] = $at['avatarurl'];
        if(isset($at['get_info_by_sms'])) $update['get_info_by_sms'] = $at['get_info_by_sms'];
        if(isset($at['member_nickname'])) $update['member_nickname'] = $at['member_nickname'];
        if(isset($at['country'])) $update['country'] = $at['country'];
        if(isset($at['province'])) $update['province'] = $at['province'];
        if(isset($at['city'])) $update['city'] = $at['city'];
        if(isset($at['area'])) $update['area'] = $at['area'];
        if(isset($at['addr'])) $update['addr'] = $at['addr'];
        if(isset($at['zip'])) $update['zip'] = $at['zip'];
        if(isset($at['email'])) $update['email'] = $at['email'];
        if(isset($at['source'])) $update['source'] = $at['source'];

        if(count($update)){
            $update['updated_at'] = date('Y-m-d H:i:s');
            User::where('id',$id)->update($update);
        }

        // 用户详情修改
        $this->detail_up($request,$id);

    }

    /**
     * 用户详情修改
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/27
     * Time: 13:43
     * @param Request $request
     */
    public function detail_up(Request $request,$id)
    {
        $at = $request->all();

        $model_detail = new UserDetail();

        $update = [];
        foreach ($model_detail->getFillable() as $v)
        {
            if(isset($at[$v])) $update[$v] = $at[$v];
        }

        if(count($update)){
            $update['updated_at'] = date('Y-m-d H:i:s');
            UserDetail::where('u_id',$id)->update($update);
        }
    }
}