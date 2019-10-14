<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class GiftVoucher extends Model
{

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


    /**
     * 店铺表
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/22
     * Time: 13:55
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function store()
    {
        return $this->hasOne(Store::class,'id','s_id')->select(['id','name']);
    }
}
