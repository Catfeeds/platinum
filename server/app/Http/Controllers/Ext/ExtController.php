<?php
/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2019/8/23
 * Time: 10:49
 */

namespace App\Http\Controllers\Ext;


use App\Http\Controllers\Controller;
use App\Http\Requests\Ext\ExtRequest;
use App\Http\Requests\Ext\UpExtRequest;
use App\Http\Success;
use App\Repository\Ext\ExtRepository;
use App\Repository\Home\User\UserRepository;
use Illuminate\Http\Request;

class ExtController extends Controller
{
    public $userRepository;
    public $extRepository;

    public function __construct(UserRepository $userRepository,ExtRepository $extRepository)
    {
        $this->userRepository = $userRepository;
        $this->extRepository = $extRepository;
    }

    /**
     * 获取用户信息
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/23
     * Time: 10:51
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_user(Request $request)
    {
        $this->validate($request,[
            'id' => 'required|numeric',
        ]);

        $data = $this->extRepository->get_user($request);

        return Success::success_ext(Success::success,$data);
    }


    /**
     * 验证是否是用户
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/27
     * Time: 11:11
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function is_user(Request $request)
    {
        $re = false;
        $mobile = $request->input('mobile','');
        $openid = $request->input('openid','');
        if($mobile || $openid)
        {
            $user = $this->userRepository->get_user($mobile,$openid);
            $re = $user ? true:$re;
        }
        return Success::success_ext(Success::success,$re);
    }

    /**
     * 用户注册
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/27
     * Time: 13:58
     * @param ExtRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(ExtRequest $request)
    {
        $re = '';
        $this->validate($request,[
            'name' => 'required|between:1,30',              //  微信昵称
            'mobile' => 'required|between:11,11',           // 手机号
            'avatarurl' => 'required|between:1,250',        // 头像
            'get_info_by_sms' => 'required|int:1,2',        // 是否愿意接受短信 1是 2否
        ]);

        // 验证用户是否已存在
        $userR = new UserRepository();
        $mobile = $request->input('mobile','');
        if($userR->get_user($mobile))
        {
            return Success::success_ext(Success::register_error);
        }

        $re = $this->extRepository->register($request);

        return Success::success_ext(Success::success,$re);
    }

    /**
     * 用户修改
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/27
     * Time: 17:29
     * @param UpExtRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function user_up(UpExtRequest $request)
    {
        $this->extRepository->user_up($request);

        return Success::success_ext(Success::success);
    }
}