<?php
/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2019/9/4
 * Time: 15:31
 */

namespace App\Repository\Home\Voucher;


use App\Models\Home\GiftVoucher;
use App\Models\Home\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VoucherRepository
{
    private $redis_key;

    public function __construct()
    {
        $this->redis_key = env('APP_REDIS_KEY').'vouchers';
    }
    /**
     * 设置电子券信息到redis
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/7/19
     * Time: 14:23
     */
    public function set_vouchers_redis()
    {
        $i = 0;
        $paginate = 100;
        $count = Voucher::count();
        for($i = 0; $i < ceil($count/$paginate);$i++)
        {
            $data = Voucher::offset($i*$paginate)->limit($paginate)->get();
            if(count($data))
            {
                foreach ($data as $v)
                {
                    $this->set_stock($v);
                }
            }
        }
    }

    /**
     * 电子券数据库库存同步
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/7/22
     * Time: 11:07
     * @param $gift_data
     */
    public function voucher_db_stock($data,$num)
    {
        DB::update('update vouchers set stock=?,sales=sales+? where id=?',
            [$data['stock'],$num,$data['id']]);
    }

    /**
     * 设置redis对应电子券库存
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/7/18
     * Time: 14:31
     * @param $data
     * @return mixed
     */
    public function set_stock($data)
    {
        $stock = $data->stock;
        redis_command('set',[$this->redis_key.$data->id,$stock]);
        return $data;
    }

    /**
     * 获取redis对应电子券库存
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/7/18
     * Time: 14:14
     * @param $data
     * @return mixed
     */
    public function get_stock($data)
    {
        // 库存
        $stock = redis_command('get',[$this->redis_key.$data->id]);

        $data->stock = $stock;
        return $data;
    }

    /**
     * 验证库存
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/7/18
     * Time: 14:22
     * @param $data
     * @param $num
     * @return bool
     */
    public function stock_is($data,$num)
    {
        Log::info('减库存前:'.$data['id'].'|'.$data['stock']);
        $stock = redis_command('DECRBY',[$this->redis_key.$data->id,$num]);
        if($stock < 0)
        {
            return false;
        }
        $data['stock'] = $stock;
        Log::info('减库存后:'.$data['id'].'|'.$data['stock']);
        $this->voucher_db_stock($data,$num); // 电子券数据库库存同步
        return true;
    }

    /**
     * redis 库存恢复
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/7/22
     * Time: 11:04
     * @param $data
     * @param $num
     */
    public function voucher_re($data,$num)
    {
        $data = $this->get_stock($data); // 同步reids对应库存到电子券对象
        $data['stock'] = $data['stock']+$num;
        $this->set_stock($data); // 恢复redis对应电子券库存
        $this->voucher_db_stock($data,-$num); // 电子券数据库库存同步
    }

    /**
     * 电子券详情
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/7/17
     * Time: 11:18
     * @param Request $request
     * @return mixed
     */
    public function voucher_details($id)
    {

        $data = Voucher::where('id',$id)->where('start','<',date('Y-m-d H:i:s'))
            ->where('end','>',date('Y-m-d H:i:s'))->where('stock','>',0)->first();
        return $data;
    }

    /**
     * 用户注册电子券领取
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/9/10
     * Time: 11:31
     * @param $user
     * @param Request $request
     */
    public function user_register_voucher($user,Request $request)
    {

    }
}