<?php
/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2019/9/4
 * Time: 15:31
 */

namespace App\Repository\Home\Gift;


use App\Models\Home\GiftVoucher;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GiftRepository
{
    private $redis_key;

    public function __construct()
    {
        $this->redis_key = env('APP_REDIS_KEY').'gifts';
    }
    /**
     * 设置礼品信息到redis
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/7/19
     * Time: 14:23
     */
    public function set_gift_redis()
    {
        $i = 0;
        $paginate = 100;
        $count = GiftVoucher::count();
        for($i = 0; $i < ceil($count/$paginate);$i++)
        {
            $data = GiftVoucher::offset($i*$paginate)->limit($paginate)->get();
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
     * 礼品数据库库存同步
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/7/22
     * Time: 11:07
     * @param $gift_data
     */
    public function gift_db_stock($gift_data,$num)
    {
        DB::update('update gift_vouchers set stock=?,sales=sales+? where id=?',
            [$gift_data['stock'],$num,$gift_data['id']]);
    }

    /**
     * 设置redis对应礼品库存
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/7/18
     * Time: 14:31
     * @param $gift_data
     * @return mixed
     */
    public function set_stock($gift_data)
    {
        $stock = $gift_data->stock;
        redis_command('set',[$this->redis_key.$gift_data->id,$stock]);
        return $gift_data;
    }

    /**
     * 获取redis对应礼品库存
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/7/18
     * Time: 14:14
     * @param $gift_data
     * @return mixed
     */
    public function get_stock($gift_data)
    {
        // 库存
        $stock = redis_command('get',[$this->redis_key.$gift_data->id]);

        $gift_data->stock = $stock;
        return $gift_data;
    }

    /**
     * 验证库存
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/7/18
     * Time: 14:22
     * @param $gift_data
     * @param $num
     * @return bool
     */
    public function stock_is($gift_data,$num)
    {
        Log::info('减库存前:'.$gift_data['id'].'|'.$gift_data['stock']);
        $stock = redis_command('DECRBY',[$this->redis_key.$gift_data->id,$num]);
        if($stock < 0)
        {
            return false;
        }
        $gift_data['stock'] = $stock;
        Log::info('减库存后:'.$gift_data['id'].'|'.$gift_data['stock']);
        $this->gift_db_stock($gift_data,$num); // 礼品数据库库存同步
        return true;
    }

    /**
     * redis 库存恢复
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/7/22
     * Time: 11:04
     * @param $gift_data
     * @param $num
     */
    public function gift_re($gift_data,$num)
    {
        $gift_data = $this->get_stock($gift_data); // 同步reids对应库存到礼品对象
        $gift_data['stock'] = $gift_data['stock']+$num;
        $this->set_stock($gift_data); // 恢复redis对应礼品库存
        $this->gift_db_stock($gift_data,-$num); // 礼品数据库库存同步
    }

    /**
     * 礼品详情
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/7/17
     * Time: 11:18
     * @param Request $request
     * @return mixed
     */
    public function gift_details($id)
    {

        $data = GiftVoucher::where('id',$id)->where('start','<',date('Y-m-d H:i:s'))
            ->where('end','>',date('Y-m-d H:i:s'))->where('stock','>',0)->first();
        return $data;
    }

}