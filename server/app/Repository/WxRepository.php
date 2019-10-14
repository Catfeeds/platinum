<?php
/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2019/9/3
 * Time: 15:22
 */

namespace App\Repository;

use EasyWeChat\Factory;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class WxRepository
{
    /**
     * 生成小程序二维码
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/9/3
     * Time: 15:30
     * @param string $scene
     * @param array $optional
     * @return bool|int|string
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\RuntimeException
     */
    static function qr_code(string $scene = 'Eric&1',array $optional = [
        'page'  => 'pages/index/index',
        'width' => 1280,
        'is_hyaline' => true
    ],$name)
    {
        $app = Factory::miniProgram(config('wechat.mini_program.default'));
//        $response = $app->app_code->getUnlimit($scene, $optional);    // 数量无限,但需要应用上线
        $response = $app->app_code->get($optional['page'].'?'.$scene,[
            'width' => $optional['width']
        ]);    // 数量与getQrCode合计10万个
//        $response = $app->app_code->getQrCode($optional['page'].'?'.$scene); // 数量与get合计10万个
        // $response 成功时为 EasyWeChat\Kernel\Http\StreamResponse 实例，失败为数组或你指定的 API 返回类型
        $save_path = 'storage/code/';
        if ($response instanceof \EasyWeChat\Kernel\Http\StreamResponse) {
            $filename = $response->saveAs('storage/code/', $name.'.jpg');
        }
        else
        {
            $filename = '';
            Log::info('小程序二维码生成错误:');
            Log::info($response);

        }
        return $save_path.$filename;
    }

    /**
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/9/3
     * Time: 16:09
     * @param string $order 商户订单号，需保持唯一性(只能是字母或者数字，不能包含有符号)
     * @param int $money 企业付款金额，单位为分
     * @param string $desc 企业付款操作说明信息。必填
     * @param string $openid 用户openid
     * @param string $check_name NO_CHECK：不校验真实姓名, FORCE_CHECK：强校验真实姓名
     * @param string $re_user_name 如果 check_name 设置为FORCE_CHECK，则必填用户真实姓名
     */
    static function cash_withdrawal(string $order,int $money,string $desc,string $openid,string $check_name = 'NO_CHECK',string $re_user_name = '老王')
    {
        // 小程序支付配置
        $config = config('wechat.payment.default');
        $app = Factory::payment($config);

        if(config('app.pay_debug'))
        {
        $money = 30;
        }

        $parems = [
            'partner_trade_no' => $order, // 商户订单号，需保持唯一性(只能是字母或者数字，不能包含有符号)
            'openid' => $openid,
            'check_name' => $check_name, // NO_CHECK：不校验真实姓名, FORCE_CHECK：强校验真实姓名
            're_user_name' => $re_user_name, // 如果 check_name 设置为FORCE_CHECK，则必填用户真实姓名
            'amount' => $money, // 企业付款金额，单位为分
            'desc' => $desc, // 企业付款操作说明信息。必填
        ];

        return $app->transfer->toBalance($parems);
    }

    /**
     * 微信提现返回处理
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/9/3
     * Time: 16:13
     * @param $re
     * @return string
     */
    static function cash_withdrawal_re_init($re)
    {
        Log::info($re);
        $json_re = json_encode($re);
        // 失败
        if($re['result_code'] == 'FAIL')
        {
            Log::info($re['err_code_des']);
            return '失败';
        }
        // 成功
        else if($re['result_code'] == 'SUCCESS' && $re['result_code'] == 'SUCCESS')
        {
            return '成功';
        }
        // 异常
        else
        {
            return '异常';
        }
    }
}