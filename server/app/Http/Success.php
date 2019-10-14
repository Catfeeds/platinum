<?php
/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2019/8/1
 * Time: 14:41
 */

namespace App\Http;


use Illuminate\Support\Facades\Log;

class Success
{
    const info = 202;
    const code_success = 200;
    const code_sign_error = 201;        // 未登陆

    const success = 200;
    const auth = 201;
    const params = 215;
    const sign_in = 216;
    const sign_in_re = 217;
    const login_mobile = 218;
    const member_addr_up = 219;
    const gift_order_xia = 220;
    const gift_order_integral = 221;
    const gift_order_stock = 222;
    const gift_order_fail = 223;
    const user_register_voucher_store = 224;
    const user_register_voucher_is = 225;
    const user_register_voucher_stock = 226;

    /**
     * 后台
     */
    const id = 1301;
    const add = 1302;
    const update = 1303;
    const delete = 1304;
    const admin_upload_error = 1305;
    const admin_img_up_size = 1306;
    const admin_file_up_size = 1307;

    /**
     * 开放接口
     */
    const ext_sign_auth_error = 3500;
    const ext_sign_add_integral = 3501;
    const register_error = 3502;
    const receipt_add_fail = 3503;

    private static $msg_data = [
        self::success                               => '成功',
        self::auth                                  => '授权异常',
        self::params                                => '参数异常',
        self::sign_in                               => '签到失败',
        self::sign_in_re                            => '已签到',
        self::login_mobile                          => '用户已存在',
        self::member_addr_up                        => '修改错误',
        self::gift_order_xia                        => '礼品已下架',
        self::gift_order_integral                   => '用户积分不足',
        self::gift_order_stock                      => '礼品库存不足',
        self::gift_order_fail                       => '礼品兑换下单失败',
        self::user_register_voucher_store           => '验证门店可兑换券不足',
        self::user_register_voucher_is              => '已领取电子券',
        self::user_register_voucher_stock           => '电子券库存不足',

        /**
         * 后台
         */
        self::id                        => 'id不能为空',
        self::add                       => '添加异常',
        self::update                    => '修改异常',
        self::delete                    => '删除异常',
        self::admin_upload_error        => '文件上传失败',
        self::admin_img_up_size         => '图片大小不能超过5MB',
        self::admin_file_up_size        => '文件大小不能超过10MB',


        /**
         * 开放接口
         */
        self::ext_sign_auth_error       => '签名验证错误',
        self::ext_sign_add_integral     => '积分变动失败',
        self::register_error            => '用户已存在',
        self::receipt_add_fail          => '小票上传失败',
    ];

    /**
     * 获取状态msg
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/20
     * Time: 11:57
     * @param $k
     * @return mixed|string
     */
    static function get_msg($k)
    {
        $data = self::$msg_data;
        if(isset($data[$k]))
        {
            return $data[$k];
        }
        else
        {
            return '异常';
        }
    }

    /**
     * 返回方法，第二版
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/20
     * Time: 14:00
     * @param int $code
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    static function success_v2($code = 200,$data = [])
    {
        return response()->json([
            'code' => $code,
            'msg' => self::get_msg($code),
            'data' => $data,
        ]);
    }

    /**
     * 开放API返回方法
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/20
     * Time: 14:00
     * @param int $code
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    static function success_ext($code = 200,$data = [])
    {
        $datare = [
            'code' => $code,
            'msg' => self::get_msg($code),
            'data' => $data,
        ];
        Log::channel('daily_ext')->info('返回:'.json_encode($datare));
        return self::success_v2($code,$data);
    }

    /**
     * 返回方法
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/1
     * Time: 14:41
     * @param array $data
     * @param string $msg
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    static function success($data = [],$msg = '成功',$code = success::code_success)
    {
        return response()->json([
            'code' => $code,
            'msg' => $msg,
            'data' => $data,
        ]);
    }
}