<?php

namespace App;

use App\Models\Home\Tarea;
use App\Models\Home\UserDetail;
use App\Models\Home\VoucherOrder;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Redis;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'mobile',
        'password',
        'member_nickname',
        'avatarurl',
        'xcx_openid',
        'integral',
        'country',
        'province',
        'city',
        'area',
        'addr',
        'zip',
        'email',
        'first_sales_date',
        'member_no',
        'tier',
        'upgrade_date',
        'get_info_by_sms'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        // TODO: Implement getJWTIdentifier() method.
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        // TODO: Implement getJWTCustomClaims() method.
        return [];
    }

    /**
     * 头像字段处理
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/19
     * Time: 14:25
     * @param $v
     * @return string
     */
    public function getAvatarurlAttribute($v)
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

    /**
     * 省
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/22
     * Time: 16:28
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function provinced()
    {
        return $this->hasOne(Tarea::class,'id','province')->where('level',1);
    }

    /**
     * 市
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/22
     * Time: 16:28
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function cityd()
    {
        return $this->hasOne(Tarea::class,'id','city')->where('level',2);
    }

    /**
     * 区
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/22
     * Time: 16:28
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function aread()
    {
        return $this->hasOne(Tarea::class,'id','area')->where('level',3);
    }

    /**
     * 用户详情
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/23
     * Time: 10:44
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function detail()
    {
        return $this->hasOne(UserDetail::class,'u_id','id');
    }

    /**
     * 生成会员编号
     * @return string
     */
    static function generateMemberNO() {
        $key_name = env('APP_REDIS_KEY').'Member:Today:RegisterList:' . date('Ymd');
        $result = Redis::setnx($key_name, 0);
        if ($result) {
            Redis::expireat($key_name, (mktime(23, 59, 59) + 1));
        }

        $value = Redis::incr($key_name);
        $no = 'Member'.date('Ymd') . str_pad($value, 4, '0', STR_PAD_LEFT);
        return $no;
    }

    /**
     * 关联用户注册领取的电子券
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/9/10
     * Time: 11:52
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function get_store_voucher()
    {
        return $this->hasOne(VoucherOrder::class,'u_id','id')->where('s_id','<>',null);
    }
}
