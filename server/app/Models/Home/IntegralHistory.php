<?php

namespace App\Models\Home;

use App\Repository\IntegralRepository;
use Illuminate\Database\Eloquent\Model;

class IntegralHistory extends Model
{
    protected $table = 'integral_historys';

    /**
     * 事件处理
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/22
     * Time: 16:08
     * @param string $v
     * @return mixed
     */
    public function getEventAttribute($v)
    {
        return IntegralRepository::get_event($v,'msg');
    }
}
