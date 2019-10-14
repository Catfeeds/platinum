<?php
/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2019/8/21
 * Time: 16:33
 */

namespace App\Repository\Scrm;


use App\Repository\GuzzleRepository;
use http\Client\Curl\User;
use Illuminate\Support\Facades\Log;

class ScrmMiRepository
{
    private $url = 'https://pt-interface.preciousplatinum.com.cn/pt-wmt-interface/';

    private $cId = 'e704f46d68e0479b9285c6143afc9b89';

    /**
     * 积分变动
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/21
     * Time: 16:38
     * @return string
     */
    public function loyalty($cid = '')
    {
        $url = $this->url.'behavior/loyalty';

        $params = [];
        $params['type'] = 1;
        $params['behavior'] = config('app.scrm_bs');
        $params['cId'] = $cid == '' ? $this->cId : $cid;
        $params['multiple'] = 1;
        $params['taskId'] = time();

        $data = GuzzleRepository::post($url,['query'=>$params]);
        return $data;
    }

    /**
     * 积分查询
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/21
     * Time: 16:44
     * @param $id
     * @return bool|string
     */
    public function info($id)
    {
        $user = \App\User::find($id);
        if($user)
        {
            $url = $this->url.'behavior/info';
            $params = [];

            $params['mobile'] = $user['mobile'];
            $data = GuzzleRepository::post($url,['query'=>$params]);
            return $data;
        }
        return false;
    }

    /**
     * 积分历史
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/21
     * Time: 16:44
     * @param $id
     * @return bool|string
     */
    public function list($id,$cid = '')
    {
        $user = \App\User::find($id);
        if($user)
        {
            $url = $this->url.'behavior/list';
            $params = [];
            $params['cId'] = $cid == ''?$this->cId:$cid;
            $data = GuzzleRepository::post($url,['query'=>$params]);
            return $data;
        }
        return false;
    }

    /**
     * 小票上传
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/26
     * Time: 14:05
     * @param $id
     * @return bool|string
     */
    public function receipt_add($id)
    {
        $user = \App\User::find($id);
        if($user)
        {
            $ob = new ScrmRepository();
            $url = $this->url.'api/receipt';
            $params = [];

            $params['openid'] = $user['xcx_openid'];
            $params['customerId'] = $this->cId;
            $params['buyTime'] = date('Y-m-d');
            $params['buyMoney'] = 1000;
            $params['gramNumber'] = 10;
            $params['buyType'] = '女戒';
            $params['brand'] = '铂金';
            $params['reason'] = '好看';
            $params['proof'] = 'https://platinumtest.beats-digital.com/storage/images/2019/08/23/Cn5BZp2OaV2Mwxr0ajJq5vAU6q2RtZXN8kWb7UKU.jpeg';
            $params['status'] = 1;
            $params['dismissalReason'] = '无';
            $params['createTime'] = date('Y-m-d');
            $params['appkey'] = $ob->appkey;
            $token = $ob->yw_get_token($params);
            $params['Token'] = $token;
            Log::info('url:'.$url);
            Log::info(json_encode($params));
            $data = GuzzleRepository::post($url,['query'=>$params]);
            return $data;
        }
        return false;
    }

    /**
     * 小票历史
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/21
     * Time: 16:58
     * @param $id
     * @return bool|string
     */
    public function receipt($id)
    {
        $user = \App\User::find($id);
        if($user)
        {
            $ob = new ScrmRepository();

            $url = $this->url.'api/receipt/list';
            $params = [];

            $params['openid'] = $user['xcx_openid'];
            $params['appkey'] = $ob->appkey;
            $token = $ob->yw_get_token($params);
            $params['Token'] = $token;
            Log::info('url:'.$url);
            Log::info('params:'.json_encode($params));
            $data = GuzzleRepository::post($url,['query'=>$params]);
            return $data;
        }
        return false;
    }
}