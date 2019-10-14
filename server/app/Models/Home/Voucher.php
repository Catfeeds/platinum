<?php

namespace App\Models\Home;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $table = 'vouchers';

    /**
     * 轮播图字段处理
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/22
     * Time: 13:43
     * @param $value
     * @return false|string
     */
    public function setImgsAttribute($value)
    {
        return $this->attributes['imgs'] = json_encode($value);
    }
}
