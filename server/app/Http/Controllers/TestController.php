<?php
/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2019/8/22
 * Time: 15:15
 */

namespace App\Http\Controllers;


use App\Repository\Home\AuthRepository;
use App\Repository\Home\Gift\GiftOrderRepository;
use App\Repository\Home\Gift\GiftRepository;
use App\Repository\Home\User\UserRepository;
use App\Repository\Home\Voucher\VoucherRepository;
use App\Repository\IntegralRepository;
use App\Repository\WxRepository;
use Illuminate\Http\Request;

class TestController extends Controller
{

    /**
     * 开放接口签名生成
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/22
     * Time: 15:18
     */
    public function sign()
    {
        $key = env('EXT_SIGN_KEY');
        $time = time();

        $params = [
            'id' => '14',
            'province' => '上海市',
            'city' => '上海市',
            'area' => '嘉定区2',
            'source' => 'wx',
        ];

        ksort($params);

        $sign_str = $key . join('', $params) . $time;


        dd(
            [
                $time,
                md5($sign_str)
            ]
        );
    }

    /**
     * 积分测试
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/22
     * Time: 15:15
     */
    public function integral()
    {
        $data = IntegralRepository::add(IntegralRepository::NEW_MEMBER,1);
        dd($data);
    }

    /**
     * 小程序二维码生成测试
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/9/3
     * Time: 16:16
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\RuntimeException
     */
    public function code()
    {
        set_time_limit(120);
        for ($i=221;$i<=300;$i++)
        {
            $name = 'Reboot'.$i;
//            echo $naem.'<br/>';
//            echo config('app.url_path').WxRepository::qr_code('scene='.$name.'&id=1',[
//                    'page'  => 'pages/index/index',
//                    'width' => 1280,
//                    'is_hyaline' => true
//                ],$name).'<br/>';

        }
    }

    /**
     * 微信提现测试
     * cash_withdrawal
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/9/3
     * Time: 16:18
     * @param Request $request
     */
    public function cash_withdrawal(Request $request)
    {
        $id = $request->input('id',12);
        $user = \App\User::find($id);
        if($user)
        {
            $re = WxRepository::cash_withdrawal(
                time().date('ymd').mt_rand(1,99999),
                100,
                '测试',
                $user['xcx_openid']
            );
            $re_init = WxRepository::cash_withdrawal_re_init($re);
            dd([$re,$re_init]);
        }
    }

    /**
     * 礼品库存同步到redis,用户积分同步
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/9/4
     * Time: 15:38
     */
    public function gift_stock()
    {
        $ob = new GiftRepository();
        $ob->set_gift_redis();
        $user = new UserRepository();
        $user->set_member_redis();
        $voucher = new VoucherRepository();
        $voucher->set_vouchers_redis();
    }

    /**
     * 新用户-scrm注册逻辑测试
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/9/9
     * Time: 15:50
     * @param Request $request
     */
    public function scrm_regist(Request $request)
    {
        $id = $request->input('id','');
        $auth = new AuthRepository();
        $auth->scrm_regist($id);
    }
}