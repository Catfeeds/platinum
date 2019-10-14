<?php
/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2019/8/21
 * Time: 13:18
 */

namespace App\Repository\Scrm;


use App\Repository\GuzzleRepository;
use App\User;
use Illuminate\Support\Facades\Log;

class ScrmRepository
{
    private $token;
    private $accesstoken;
    public $appkey;
    private $url;
    private $scrm_token_path = '../scrm_token';
    private $openid;
    private $secret;
    private $appid;

    /**
     * 初始化
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/21
     * Time: 13:21
     */
    public function __construct()
    {
        $this->get_scrm();
        $this->appkey = env('SCRM_APPKEY');
        $this->url = env('SCRM_URL');
        $this->openid = env('SCRM_OPENID');
        $this->secret = env('SCRM_SECRET');
        $this->appid = env('SCRM_APPID');
    }

    /**
     * 保存信息
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/21
     * Time: 15:13
     */
    private function set_scrm()
    {

        $data = [];
        $data['token'] = $this->token;
        $data['accesstoken'] = $this->accesstoken;
        file_put_contents($this->scrm_token_path,json_encode($data));

    }

    /**
     * 获取信息
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/21
     * Time: 15:14
     */
    private function get_scrm()
    {
        $data = file_get_contents($this->scrm_token_path);
        if(json_decode($data,true))
        {
            $data = json_decode($data,true);
            $this->token = $data['token'];
            $this->accesstoken = $data['accesstoken'];
        }
    }

    /**
     * 获取token
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/21
     * Time: 13:36
     * @return mixed
     */
    public function get_token()
    {
        $url = $this->url.'getToken?appKey='.$this->appkey;
        $data = GuzzleRepository::get($url);
        $data = $this->data_init($data);

        if($data)
        {
            $this->token = $data['token'];
            $this->set_scrm();
        }
        return $data;
    }

    /**
     * 微信授权url组合
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/21
     * Time: 15:09
     * @return string
     */
    public function wx_auth()
    {
        $appid = $this->appid;
        $type = 'userinfo'; // base：隐形授权，用户无感知，只能获取openid。userinfo： 显示授权，需要用户同意，获取openid，昵称头像等参数
        $redirectUrl = config('app.url').'redirecturl';
//        $url = $this->url.'toAuthorize/'.$appid.'/'.$type.'?redirectUrl='.urlencode($redirectUrl).'&state=state';
        $url = 'https://pt-interface.preciousplatinum.com.cn/user/auth?callback='.$redirectUrl;

        return $url;
    }

    /**
     * 获取 accesstoken
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/21
     * Time: 15:19
     * @return bool|string
     */
    public function get_accesstoken()
    {
        $openid = $this->openid;
        $openid = env('SCRM_OPENID_ACC_TI');
        $token = $this->token;
//        $token = '97DB0B66FE0307AE506222281A327CDBC83CE22144E719F2';
        $url = $this->url . $openid . '/getAccessToken?token=' . $token;
        Log::info('url:'.$url);
        $data = GuzzleRepository::get($url);
        $data = $this->data_init($data);

        if ($data)
        {
            $this->token = $data['accessToken'];
            $this->set_scrm();
        }


        return $data;
    }

    /**
     * 获取 ticket
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/21
     * Time: 15:22
     * @return bool|string
     */
    public function get_ticket()
    {
        $openid = $this->openid;
        $openid = 'gh_1af7f883de71';
        $url = $this->url . $openid . '/getTicket?token=' . $this->token;
        Log::info('url:'.$url);
        $data = GuzzleRepository::get($url);
        $data = $this->data_init($data);
        return $data;
    }

    /**
     * 判断是否是会员
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/21
     * Time: 15:35
     * @param $id
     * @return mixed
     */
    public function is_member($id)
    {
        $user = User::find($id);
        if($user)
        {
            $params = [];
            $params['openid'] = $user['xcx_openid'];
            $params['mobile'] = $user['mobile'];
            $params['Userid'] = $user['xcx_openid'];
            $params['appkey'] = $this->appkey;

            $token = $this->yw_get_token($params);
            $params['token'] = $token;

            $url = $this->url.'user/api/ismember';
            $data = GuzzleRepository::post($url,['query'=>$params]);

            return $data;
        }
        return false;
    }

    /**
     * 会员注册register
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/21
     * Time: 16:07
     * @param $id
     * @return bool|string
     */
    public function register($params)
    {
        $params['source'] = 'Reboot';
        $params['appkey'] = $this->appkey;

        $token = $this->yw_get_token($params);
        $params['token'] = $token;

        $url = $this->url.'user/api/register';
        $data = GuzzleRepository::post($url,['query'=>$params]);

        return $data;
    }

    /**
     * 查询会员信息
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/21
     * Time: 16:15
     * @param $id
     * @return bool|string
     */
    public function query_member($id)
    {
        $user = User::find($id);
        if($user)
        {
            $params = [];
            $params['openid'] = $user['xcx_openid'];
            $params['mobile'] = $user['mobile'];
            $params['Userid'] = $user['xcx_openid'];
            $params['appkey'] = $this->appkey;

            $token = $this->yw_get_token($params);
            $params['token'] = $token;

            $url = $this->url.'user/api/querymemberdata';
            $data = GuzzleRepository::post($url,['query'=>$params]);

            return $data;
        }
        return false;
    }

    /**
     * 更新会员信息
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/21
     * Time: 16:15
     * @param $id
     * @return bool|string
     */
    public function update_member($id)
    {
        $user = User::find($id);
        if($user)
        {
            $params = [];
            $params['openid'] = $user['xcx_openid'];
//            $params['mobile'] = $user['mobile'];
            $params['Userid'] = $user['xcx_openid'];
            $params['appkey'] = $this->appkey;
            $params['firstName'] = '亮';
            $params['lastName'] = '潘';

            $token = $this->yw_get_token($params);
            $params['token'] = $token;

            $url = $this->url.'user/api/updatememberdata';
            $data = GuzzleRepository::post($url,['query'=>$params]);

            return $data;
        }
        return false;
    }

    /**
     * 优惠券list
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/9/6
     * Time: 16:28
     * @return string
     */
    public function coupon_list()
    {
        $params = [];
        $openid = $this->openid;

        $params['secret'] = $this->secret;
        $params['appkey'] = $this->appkey;
        $params['openId'] = $openid;
        $token = $this->yw_get_token($params);
        $params['token'] = $token;

        $url = $this->url.'api/coupons/getAll/'.$openid;
        $data = GuzzleRepository::post($url,['query'=>$params]);
        return $data;
    }

    /**
     * 优惠券核销
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/9/6
     * Time: 16:39
     * @return string
     */
    public function coupon_write()
    {
        $params = [];
        $openid = $this->openid;

        $params['secret'] = $this->secret;
        $params['appkey'] = $this->appkey;
        $token = $this->yw_get_token($params);
        $params['token'] = $token;
        $params['data']['consumeDatas'] = [[
            'code' => '12332222',
            'type' => 'DISCOUNT',
            'channelType' => 'Wechat',
            'cardId' => 'TTTTa6swZAwDkVTr4pxbjSok4',
            'openId' => $openid,
        ]];

        $url = $this->url.'api/coupons/consume';
        $data = GuzzleRepository::post($url,['query'=>$params]);
        return $data;
    }

    /**
     * 获取业务token
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/21
     * Time: 15:32
     * @param $params
     * @return string
     */
    public function yw_get_token($params)
    {
        ksort($params);
        $str = $this->secret;
        if(count($params))
        {
            foreach ($params as $k=>$v)
            {
                $str .=$k.$v;
            }
        }
        $str .= $this->secret;
        return md5($str);
    }

    /**
     * 返回数据处理
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/21
     * Time: 14:59
     * @param $data
     * @return bool
     */
    private function data_init($data)
    {
        if($data && isset($data['code']) && $data['code'] == 1000)
        {
            Log::info($data['data']);
            return $data['data'];
        }
        else if($data && isset($data['code']) && $data['code'] == 1001&& $data['msg'] == 'token错误')
        {
            // 刷新token
            $this->get_token();
        }
        Log::info($data);
        return false;
    }

    /**
     * 业务接口返回数据处理
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/21
     * Time: 14:59
     * @param $data
     * @return bool
     */
    private function yw_data_init($data)
    {
        if($data && isset($data['code']) && $data['code'] == 0)
        {
            return $data['data'];
        }
        Log::info($data);
        return false;
    }

}