<?php
/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2019/9/10
 * Time: 13:06
 */

namespace App\Repository\Home\Voucher;


use App\Models\Home\VoucherOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VoucherOrderRepository
{
    /**
     * 订到保存
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/7/18
     * Time: 11:29
     * @param Request $request
     */
    static function order(Request $request,$user,$data,$s_id = '')
    {
        $v_id = $request->input('v_id','');
        $num = $request->input('num',1);
        $integral = $data->integral;
        $u_id = $user['id'];
        $integral_sum = $integral*$num;
        $vouchers_days = config('app.vouchers_days');

        $order = new VoucherOrder();
        $order->order_no = time().mt_rand(0,99999).mt_rand(0,99999).mt_rand(0,99999);
        $order->v_id = $v_id;
        $order->v_type = $data['type'];
        $order->num = $num;
        $order->integral = $integral_sum;
        $order->u_id = $u_id;
        $order->state = 1;
        $order->expiring_time = date('Y-m-d H:i:s',strtotime("+$vouchers_days day"));
        if($s_id) $order->s_id = $s_id;

        try {
            // 手动开始事务
            DB::beginTransaction();

            // 订单保存
            $order->save();

            // 提交事务
            DB::commit();
            return true;
        } catch (\Exception $exception) {
            // 回滚事务
            DB::rollBack();
            return false;
        }

    }
}