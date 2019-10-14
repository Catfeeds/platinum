<?php

namespace App\Http\Controllers\Home\Api;

use App\Http\Success;
use App\Repository\Home\AuthRepository;
use App\Repository\Home\User\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use EasyWeChat\Factory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class AuthController extends Controller
{

    public $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    /**
     * 小程序登陆
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/7/22
     * Time: 15:02
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $at = $this->validate(
            $request,
            [
                'name' => 'required',
                'code' => 'required',
                'mobile' => 'nullable',     // 手机号码
                'avatarUrl' => 'required',  // 头像
                'country' => 'nullable',
                'province' => 'nullable',
                'city' => 'nullable',
            ]
        );

        // 获取用户openid
        $app = Factory::miniProgram(config('wechat.mini_program.default'));
        $data_wx = $app->auth->session($at['code']);

        $mobile = isset($at['mobile'])?$at['mobile']:'';
        $userR = new UserRepository();
        $is_user_op = $userR->get_user($mobile);
        // 验证用户是否已存在
        if($mobile && $is_user_op['xcx_openid'])
        {
            return Success::success_v2(Success::login_mobile);
        }

        if(isset($data_wx['openid']))
        {
            $data = $this->authRepository->login($request,$data_wx);
            return Success::success_v2(Success::success,$data);
        }
        return Success::success_v2(Success::auth);
    }

    /**
     * 微信手机号消息解密
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/7/22
     * Time: 15:11
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function decryptData(Request $request)
    {
        $at = $this->validate(
            $request,
            [
                'encryptedData' => 'required',
                'iv' => 'required',
                'code' => 'required',
            ],
            [
                'encryptedData.required' => 'encryptedData不能为空',
                'iv.required' => 'iv不能为空',
                'code.required' => 'code不能为空',
            ]
        );

        // 获取用户openid
        $app = Factory::miniProgram(config('wechat.mini_program.default'));
        $data_wx = $app->auth->session($at['code']);
        $data = [];
        if(isset($data_wx['openid']))
        {
            $data = $this->authRepository->decryptData($request,$data_wx);
            if($data['mobile'])
            {
                return Success::success_v2(Success::success,$data);
            }
        }
        Log::info('手机号解密:'.json_encode($data_wx).'|'.json_encode($data));
        return Success::success_v2(Success::auth);
    }


}
