<?php
/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2019/8/22
 * Time: 15:54
 */

namespace App\Repository\Home\User;


use App\Models\Home\IntegralHistory;
use App\Models\Home\UserDetail;
use App\Models\Home\UserSignIn;
use App\Repository\IntegralRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserRepository
{
    private $redis_key;

    public function __construct()
    {
        $this->redis_key = env('APP_REDIS_KEY').'users';
    }
    /**
     * 积分历史
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/22
     * Time: 16:20
     * @param Request $request
     * @param $user
     * @return array|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function integral(Request $request,$user)
    {
        $data = [];
        $u_id = $user->id;
        $time = $request->input('time','');
        $paginate = $request->input('paginate',10);

        $query = IntegralHistory::query();
        $query->orderBy('id','DESC');

        if($time) $query->whereBetween('created_at',$time);

        $data = $query->paginate($paginate);

        return $data;
    }

    /**
     * 根据手机号或openid查询用户
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/27
     * Time: 11:07
     * @param string $mobile
     * @param string $openid
     * @return mixed
     */
    public function get_user($mobile = '',$openid = '')
    {
        $val = $mobile != ''?$mobile:$openid;
        $key = $mobile != ''?'mobile':'xcx_openid';
        $user = User::where($key,$val)->first();
        return $user;
    }

    /**
     * 用户详细信息
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/22
     * Time: 16:26
     * @param $user
     * @return mixed
     */
    public function userinfo($user)
    {
        $data = User::where('id',$user['id'])->with(['provinced','cityd','aread','detail'])->first();
        return $data;
    }

    /**
     * 用户详细信息修改
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/23
     * Time: 15:38
     * @param Request $request
     * @param $user
     * @return bool
     */
    public function user_detail(Request $request,$user)
    {
        $re = true;
        $u_id = $user['id'];
        $at = $request->all();

        $model_detail = UserDetail::where('u_id',$u_id)->first();
        $model_detail->age = $at['age'];
        if(isset($at['memorial_day_name'])) $model_detail->memorial_day_name = $at['memorial_day_name'];
        if(isset($at['memorial_date'])) $model_detail->memorial_date = $at['memorial_date'];
        if(isset($at['constellation'])) $model_detail->constellation = $at['constellation'];
        $model_detail->job = $at['job'];
        if(isset($at['salary'])) $model_detail->salary = $at['salary'];
        $model_detail->is_marr = $at['is_marr'];
        $model_detail->is_sub = $at['is_sub'];
        $model_detail->sex = $at['sex'];
        $model_detail->full_name = $at['full_name'];
        $model_detail->birthday = $at['birthday'];
        $model_detail->age = $at['age'];

        try {
            $model_detail->save();

            // 修改用户信息
            User::where('id',$u_id)->update([
                'get_info_by_sms' => $at['get_info_by_sms'],
                'email' => $at['email'],
                'zip' => $at['zip'],
                'addr' => $at['addr'],
                'province' => $at['province'],
                'city' => $at['city'],
                'area' => $at['area'],
                'get_info_by_sms' => $at['get_info_by_sms'],
            ]);

            $re = true;
        } catch (\Exception $exception) {
            $re = false;
        }

        return $re;
    }

    /**
     * 修改基础信息
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/23
     * Time: 15:43
     * @param Request $request
     * @param $user
     * @return bool
     */
    public function user_base(Request $request,$user)
    {
        $re = true;
        $u_id = $user['id'];
        $at = $request->all();

        $update = [];
        if(isset($at['avatarurl']))
        {
            $at['avatarurl'] = img_path_get_re($at['avatarurl']);
            $update['avatarurl'] = $at['avatarurl'];
        }
        if(isset($at['member_nickname'])) $update['member_nickname'] = $at['member_nickname'];

        try {
            if(count($update)) User::where('id',$u_id)->update($update);
            $re = true;
        } catch (\Exception $exception) {
            $re = false;
        }

        return $re;
    }

    /**
     * 用户签到
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/23
     * Time: 16:11
     * @param $user
     * @return bool|string
     */
    public function sign_in($user)
    {
        $re = false;
        $myfile = fopen('../sign_in', "a+"); // 文件锁地址
        //加锁,阻塞模式
        if(flock($myfile,LOCK_EX))
        {
            $id = $user['id'];
            try {
                // 查询用户是否签到
                $userSignIn = new UserSignIn();
                $sign = $userSignIn->where('u_id',$id)->whereBetween('created_at',[
                    date('Y-m-d 00:00:00'),
                    date('Y-m-d 23:59:59'),
                ])->first();

                if(!$sign)
                {
                    $event = IntegralRepository::SIGN_IN;
                    $integral = IntegralRepository::get_event($event,'value');
                    // 签到记录保存
                    $userSignIn->u_id = $id;
                    $userSignIn->integral = $integral;
                    $userSignIn->save();

                    // 签到积分记录添加,用户积分余额添加
                    IntegralRepository::add($event,$id);

                    $re = true;
                }
                else
                {
                    $re = '已签到';
                }
            } catch (\Exception $exception) {
                $re = false;
            }
        }

        fclose($myfile); // 关闭文件
        return $re;
    }

    /**
     * 用户签到list
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/23
     * Time: 16:17
     * @param Request $request
     * @param $user
     * @return mixed
     */
    public function sign_list(Request $request,$user)
    {
        $time = $request->input('time',date('Y-m-d')); // 时间，默认查询当前月

        $start = date('Y-m-01 00:00:00',strtotime($time));  // 开始时间
        $end = date('Y-m-d 23:59:59',strtotime("+1 month $start -1 day"));

        $data = UserSignIn::where('u_id',$user['id'])->whereBetween('created_at',[$start,$end])->get();

        return $data;
    }


    /**
     * 设置会员信息到redis
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/7/19
     * Time: 14:23
     */
    public function set_member_redis()
    {
        $i = 0;
        $paginate = 100;
        $count = User::count();
        for($i = 0; $i < ceil($count/$paginate);$i++)
        {
            $data = User::offset($i*$paginate)->limit($paginate)->get();
            if(count($data))
            {
                $redis_com = [];
                $redis_com[] = $this->redis_key;
                foreach ($data as $v)
                {
                    $this->set_key_member_redis($v);
                }
            }
        }
    }

    /**
     * 获取redis会员信息
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/7/19
     * Time: 14:27
     * @param $id
     * @return mixed
     */
    public function get_member_redis($user)
    {
        $remain_intergration = redis_command('get',[$this->redis_key.$user['id']]);
        $user['integral'] = $remain_intergration;
        return $user;
    }

    /**
     * 更新会员redis指定字段的值
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/7/19
     * Time: 14:38
     * @param $user
     */
    public function set_key_member_redis($user)
    {
        redis_command('set',[$this->redis_key.$user['id'],$user['integral']]);
    }

    /**
     * 验证会员余额是否够,会员redis积分消费
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/7/19
     * Time: 14:38
     * @param $user
     * @param $sum_integral
     * @return bool
     */
    public function integral_is($user,$sum_integral)
    {
        $remain_intergration = redis_command('DECRBY',[$this->redis_key.$user['id'],$sum_integral]);
        if($remain_intergration < 0)
        {
            return false;
        }
//        $this->up_remain_intergration($user,$sum_integral);
        return true;
    }

    /**
     * TODO::会员积分消费
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/7/18
     * Time: 15:52
     * @param $user
     * @param $intergration
     * @return bool
     */
    public function up_remain_intergration($user,$intergration)
    {
        $re = DB::update('update users set integral=integral-? where id=?',
            [$intergration,$user['id']]);
        if($re)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * 恢复会员redis积分
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/7/19
     * Time: 16:23
     * @param $user
     */
    public function integral_re($user,$sum_integral)
    {
        $user = $this->get_member_redis($user); // redis会员信息同步
        $this->set_key_member_redis($user); //会员redis积分恢复
        $this->add_remain_intergration($user,$sum_integral); // 会员积分恢复
    }

    /**
     * 会员积分恢复
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/7/18
     * Time: 15:58
     * @param $user
     * @param $intergration
     * @return bool
     */
    public function add_remain_intergration($user,$intergration)
    {
        $re = DB::update('update users set integral=integral+? where id=?',
            [$intergration,$user['id']]);
        if($re)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}