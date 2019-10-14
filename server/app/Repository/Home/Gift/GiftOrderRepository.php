<?php
/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2019/9/4
 * Time: 15:30
 */

namespace App\Repository\Home\Gift;


use App\Models\Home\GiftOrders;
use App\Repository\IntegralRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GiftOrderRepository
{
    /**
     * 下单
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/7/18
     * Time: 11:29
     * @param Request $request
     */
    public function order(Request $request,$user,$gift_data)
    {
        $g_id = $request->input('g_id','');
        $u_d_id = $request->input('u_d_id','');
        $type = $request->input('type',1);
        $num = $request->input('num',1);
        $integral = $gift_data->integral;
        $u_id = $user['id'];
        $integral_sum = $integral*$num;

        $order = new GiftOrders();
        $order->order_no = time().mt_rand(0,99999).mt_rand(0,99999).mt_rand(0,99999);
        $order->g_id = $g_id;
        $order->num = $num;
        $order->integral = $integral_sum;
        $order->u_id = $u_id;
        $order->u_d_id = $u_d_id;
        $order->state = 1;
        $order->type = $type;

        try {
            // 手动开始事务
            DB::beginTransaction();

            // 订单保存
            $order->save();

            // 积分记录添加
            IntegralRepository::add(IntegralRepository::BUY_GIFT,$u_id,$integral_sum);

            // 提交事务
            DB::commit();
            return true;
        } catch (\Exception $exception) {
            // 回滚事务
            DB::rollBack();
            return false;
        }

    }

    /**
     * 获取订单自动确认收货时间
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/9/5
     * Time: 16:05
     * @return false|string
     */
    public function get_automatic_time()
    {
        $day = config('app.gift_day');
        return date('Y-m-d H:i:s',strtotime("+ $day day"));
    }
}