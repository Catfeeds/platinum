<?php

namespace App\Models\Home;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    protected $table = 'user_detail';

    protected $fillable = [
        'age',
        'memorial_day_name',
        'memorial_date',
        'constellation',
        'job',
        'salary',
        'is_marr',
        'is_sub',
        'sex',
        'full_name',
        'birthday',
        'wechat_follow_date',
    ];
}
