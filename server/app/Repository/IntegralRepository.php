<?php
/**
 * 积分操作公共方法
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2019/8/22
 * Time: 14:53
 */

namespace App\Repository;


use App\Models\Home\IntegralHistory;
use Illuminate\Support\Facades\DB;

class IntegralRepository
{
    const ERROR = 0;
    const NEW_MEMBER = 1;
    const BUY_PRODUCT = 2;
    const ACTIVITY_SIGN = 3;
    const INVITE_GOOD_FRIENDS = 4;
    const MANUAL = 5;
    const SIGN_IN = 6;
    const BUY_GIFT = 7;

    /**
     * 开放接口使用
     * @var array
     */
    const VIDEO = 501;
    const EXT_TEST = 502;

    public $event = [
        self::ERROR                     => ['value'=>0,'msg'=>'异常'],
        self::NEW_MEMBER                => ['value'=>10,'msg'=>'新会员注册'],
        self::BUY_PRODUCT               => ['value'=>10,'msg'=>'产品购买'],
        self::ACTIVITY_SIGN             => ['value'=>10,'msg'=>'活动打卡'],
        self::INVITE_GOOD_FRIENDS       => ['value'=>10,'msg'=>'邀请好友'],
        self::MANUAL                    => ['value'=>11,'msg'=>'手动调整'],
        self::SIGN_IN                   => ['value'=>1,'msg'=>'签到'],
        self::BUY_GIFT                  => ['value' => 0,'msg' => '礼品兑换'],

        /**
         * 开放接口使用
         */
        self::VIDEO                     => ['value'=>10,'msg'=>'视频互动'],
        self::EXT_TEST                  => ['value'=>1,'msg'=>'开放接口测试'],
    ];

    /**
     * 获取积分事件对应值
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/22
     * Time: 15:03
     * @param $k
     * @return mixed
     */
    static function get_event($k,$key)
    {
        $object = new IntegralRepository();
        $data = $object->event;
        if(isset($data[$k]))
        {
            return $data[$k][$key];
        }
        return $data[self::ERROR][$key];
    }

    /**
     * 积分添加
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/22
     * Time: 15:06
     * @param int $event 事件
     * @param int $u_id 用户id
     * @param int $num 变动积分值,值为0的情况取默认值
     * @param string $re
     * @return bool|mixed|string
     */
    static function add($event,$u_id,$num = 0,$restr = '')
    {
        // 获取积分变动值
        $num = $num == 0 ? $num = self::get_event($event,'value'):$num;
        $re = true;
        $model = new IntegralHistory();
        $model->num = $num;
        $model->event = $event;
        $model->u_id = $u_id;
        $model->re = $restr;
        try
        {
            // 手动开始事务
            DB::beginTransaction();
            $model->save();
            $re = $model->id;
            if($event != self::BUY_GIFT)
            {
                // 更改用户积分
                UserRepository::up_integral($num,$u_id);
            }

            // 提交事务
            DB::commit();
        }catch (\Exception $exception)
        {
            // 回滚事务
            DB::rollBack();
            $re = false;
        }
        return $re;
    }
}