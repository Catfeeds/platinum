<?php

namespace App\Http\Controllers\Home\Api\Gift;

use App\Http\Success;
use App\Repository\Home\Gift\GiftOrderRepository;
use App\Repository\Home\Gift\GiftRepository;
use App\Repository\Home\User\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GiftOrderController extends Controller
{
    public $giftRepository;
    public $userRepository;
    public $giftOrderRepository;
    public function __construct(GiftRepository $giftRepository,UserRepository $userRepository,GiftOrderRepository $giftOrderRepository)
    {
        $this->giftRepository = $giftRepository;
        $this->userRepository = $userRepository;
        $this->giftOrderRepository = $giftOrderRepository;
    }

    public function gift_order(Request $request)
    {
        $g_id = $request->input('g_id','');     // 礼品id
        $num = $request->input('num',1);        // 礼品数量
        $type = $request->input('type',1);      // 领取方式 1物流 2到店

        $giftRepository = $this->giftRepository;
        $userRepository = $this->userRepository;
        $giftOrderRepository = $this->giftOrderRepository;

        $gift_data = $giftRepository->gift_details($g_id); // 从数据库查询礼品对象

        $is = '';
        $re = '';
        if($gift_data)
        {
            // 减用户积分
            $sum_integral = $num*$gift_data->integral;

            $gift_data = $giftRepository->get_stock($gift_data); // 同步reids对应库存到礼品对象
//
            $user = Auth::user(); // 用户信息
            $user = $userRepository->get_member_redis($user); // redis用户信息同步
            $stock = $gift_data->stock; // 库存
            // 验证用户余额
            if($user && $userRepository->integral_is($user,$sum_integral))
            {
                $userRepository->up_remain_intergration($user,$sum_integral);  // 会员积分消费
                // 验证库存
                if($stock > 0 && $stock >= $num  && $giftRepository->stock_is($gift_data,$num))
                {
                    $user = $userRepository->get_member_redis($user); // redis会员信息同步
                    Log::info($user);
                    $re = $giftOrderRepository->order($request,$user,$gift_data); // 下单
                    if(!$re)
                    {
                        $is = Success::gift_order_fail; // 礼品兑换下单失败
                    }
                }
                else
                {
                    $is = Success::gift_order_stock;    // 礼品库存不足
                }
                // 库存验证成功或者下单成功
                if($is == '' || $re)
                {
                    $is = Success::success; // 成功
                }
                else
                {
                    $giftRepository->gift_re($gift_data,$num); // 恢复redis对应礼品库存
                    $userRepository->integral_re($user,$sum_integral); // 恢复会员redis积分
                }
                return Success::success_v2($is);
            }
            else
            {
                return Success::success_v2(Success::gift_order_integral);   // 用户积分不足
            }
        }
        return Success::success_v2(Success::gift_order_xia);    // 礼品已下架
    }
}
