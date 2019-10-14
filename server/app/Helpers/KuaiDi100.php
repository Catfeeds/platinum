<?php
namespace App\Helpers;
/**
 * Created by PhpStorm.
 * User: xhkj
 * Date: 2019/1/14
 * Time: 下午4:36
 */
class KuaiDi100
{
    /**
     * 快递查询
     *
     * @param $com
     * @param $num
     * @return mixed
     */
    public function cha_xun($com,$num)
    {
        //参数设置
        $post_data = array();
        $post_data["customer"] = env('KUAI_DI_100_CUSTOMER');
        $key= env('KUAI_DI_100_KEY') ;
        $post_data["param"] = '{"com":"'.$com.'","num":"'.$num.'"}';

        $url='https://poll.kuaidi100.com/poll/query.do';
        $post_data["sign"] = md5($post_data["param"].$key.$post_data["customer"]);
        $post_data["sign"] = strtoupper($post_data["sign"]);
        $o="";
        foreach ($post_data as $k=>$v)
        {
            $o.= "$k=".urlencode($v)."&";		//默认UTF-8编码格式
        }
        $post_data=substr($o,0,-1);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
//        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//这个是重点。
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        return $result;
    }
}