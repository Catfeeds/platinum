<?php
/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2019/9/3
 * Time: 16:32
 */

namespace App\Models\Home;

use Illuminate\Database\Eloquent\Model;
class Member_addr extends Model
{
    protected $table = 'member_addr';

    /**
     * 未删除和城市查询条件
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/7/18
     * Time: 10:50
     * @param $query
     * @param int $delete
     * @return mixed
     */
    public function scopeWhereDeleteWith($query,$delete = 0)
    {
        return $query->where('delete',0)->with(['province','city','area']);
    }

    /**
     * 省
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/7/18
     * Time: 10:45
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function province()
    {
        return $this->hasOne(Tarea::class,'id','province_id');
    }

    /**
     * 市
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/7/18
     * Time: 10:45
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function city()
    {
        return $this->hasOne(Tarea::class,'id','city_id');
    }

    /**
     * 区
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/7/18
     * Time: 10:45
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function area()
    {
        return $this->hasOne(Tarea::class,'id','area_id');
    }
}