<?php
/**
 * 用户操作公共方法
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2019/8/22
 * Time: 15:33
 */

namespace App\Repository;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserRepository
{
    /**
     * 更改用户积分
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/22
     * Time: 15:34
     * @param $num
     * @param $u_id
     */
    static function up_integral($num,$u_id)
    {
        DB::update('update users set integral=integral+? where id=?',[$num,(int)$u_id]);
    }
}