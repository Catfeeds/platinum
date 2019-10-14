<?php

namespace App\Http\Middleware\Home;

use App\Http\Success;
use Closure;
use Illuminate\Support\Facades\Log;

class ExtSign
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $data_all = $request->all();
        Log::channel('daily_ext')->info('请求:'.json_encode($data_all));
        $timestamp = '';
        $sign = '';
        if(isset($data_all['timestamp']))
        {
            $timestamp = $data_all['timestamp'];
            unset($data_all['timestamp']);
        }
        if(isset($data_all['sign']))
        {
            $sign = $data_all['sign'];
            unset($data_all['sign']);
        }

        if($timestamp == '' || $sign == '' || $this->checkRequest($data_all,$timestamp,$sign) === false)
        {
            return Success::success_ext(Success::ext_sign_auth_error);
        }

        return $next($request);
    }


    /**
     * 签名验证
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/16
     * Time: 11:04
     * @param array $param 参数
     * @param string $timestamp 时间戳
     * @param string $sign 签名
     * @return bool
     */
    private function checkRequest($param, $timestamp, $sign) {
        $key = env('EXT_SIGN_KEY');
        ksort($param);
        $sign_str = $key . join('', $param) . $timestamp;

        return md5($sign_str) === $sign ? true : false;
    }
}
