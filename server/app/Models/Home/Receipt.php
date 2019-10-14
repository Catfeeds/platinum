<?php

namespace App\Models\Home;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    public function getReceiptImgAttribute($v)
    {
        if($v)
        {
            if(stripos($v,'http') !== false)
            {
                return $v;
            }
            return img_path_get().$v;
        }
        return '';
    }

    public function getProductImgAttribute($v)
    {
        if($v)
        {
            if(stripos($v,'http') !== false)
            {
                return $v;
            }
            return img_path_get().$v;
        }
        return '';
    }
}
