<?php
/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2019/9/10
 * Time: 11:36
 */

namespace App\Repository\Home\Store;


use Illuminate\Support\Facades\DB;

class StoreRepository
{
    /**
     * 注册电子券领取剩余数量-更改
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/7/22
     * Time: 11:07
     * @param $gift_data
     */
    static function stores_voucher_num($id,$num)
    {
        try{
            DB::update('update stores set voucher_num=voucher_num+? where id=?',
                [$num,$id]);
            return true;
        }catch (\Exception $exception)
        {
            return false;
        }
    }
}