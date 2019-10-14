<?php

/**
 * 返回图片路径
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2019/7/16
 * Time: 16:08
 * @return string
 */
function img_path_get()
{
    return config('app.url').'storage/';
}

/**
 * 图片地址公共部分替换为空
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2019/8/5
 * Time: 17:09
 * @param $str
 * @return mixed
 */
function img_path_get_re($str)
{
    return str_replace(img_path_get(),'',$str);
}

/**
 * 根据手机号登录方法
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2019/7/17
 * Time: 15:17
 * @param $mobile
 * @return \Illuminate\Http\JsonResponse
 * @throws Exception
 */
function login_jwt($mobile)
{
    $token = '';
    $user = \App\User::where('mobile',$mobile)->first();
    if($user)
    {
        $password = \Ramsey\Uuid\Uuid::uuid1();
        // 更改用户密码
        \App\User::where('id',$user->id)->update([
            'password' => bcrypt($password)
        ]);
        // token生成
        $token = \Illuminate\Support\Facades\Auth::guard('api')->attempt([
            'mobile' => $mobile,
            'password' => $password
        ]);
        return 'Bearer '.$token;
    }
    return '';
}

/**
 * redis command 执行
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2019/7/18
 * Time: 14:08
 * @param $key
 * @param $key_arr
 * @return mixed
 */
function redis_command($key,$key_arr)
{
    return \Illuminate\Support\Facades\Redis::command($key,$key_arr);
}

/**
 * 二维数组排序
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2019/7/29
 * Time: 14:29
 * @param $data
 * @param $key
 * @return mixed
 */
function data_order($data,$key)
{
    if(count($data))
    {
        //根据字段last_name对数组$data进行降序排列
        $last_names = array_column($data,$key);
        array_multisort($last_names,SORT_ASC,$data);
    }
    return $data;
}

/**
 * 二维数组统计
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2019/8/16
 * Time: 15:56
 * @param $arr
 * @param $key
 * @return int
 */
function sum_arr_key($arr,$key)
{
    $sum = 0;
    if(count($arr))
    {
        foreach ($arr as $v)
        {
            $sum+=$v[$key];
        }
    }
    return $sum;
}

?>