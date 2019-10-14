<?php
/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2019/8/21
 * Time: 13:18
 */

namespace App\Http\Controllers\Scrm;


use App\Http\Controllers\Controller;
use App\Http\Success;
use App\Repository\Scrm\ScrmMiRepository;
use App\Repository\Scrm\ScrmRepository;
use App\User;
use Illuminate\Http\Request;

class ScrmController extends Controller
{
    public $scrmRepository;
    public $scrmMiRepository;

    public function __construct(ScrmRepository $scrmRepository,ScrmMiRepository $scrmMiRepository)
    {
        $this->scrmRepository = $scrmRepository;
        $this->scrmMiRepository = $scrmMiRepository;
    }

    /**
     * 获取token
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/21
     * Time: 13:36
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_token()
    {
        $data = $this->scrmRepository->get_token();
        return Success::success_v2(Success::success,$data);
    }

    /**
     * 微信授权跳转
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/21
     * Time: 15:10
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function wx_auth()
    {
        $url = $this->scrmRepository->wx_auth();
//        echo $url.'<br/>';exit;
        return redirect($url);
    }

    /**
     * 获取 accesstoken
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/21
     * Time: 15:18
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_accesstoken()
    {
        $data = $this->scrmRepository->get_accesstoken();
        return Success::success_v2(Success::success,$data);
    }

    /**
     * 获取 ticket
     * 用于获取微信JSSDK 网页分享签名凭证jsapi_ticket
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/21
     * Time: 15:21
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_ticket()
    {
        $data = $this->scrmRepository->get_ticket();
        return Success::success_v2(Success::success,$data);
    }

    /**
     * 判断是否是会员
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/21
     * Time: 15:36
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function is_member(Request $request)
    {
        $id = $request->input('id',1);
        $data = $this->scrmRepository->is_member($id);
        return Success::success_v2(Success::success,$data);
    }

    /**
     * 会员注册register
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/21
     * Time: 15:36
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $id = $request->input('id',1);
        $user = User::find($id);
        $data = [];
        if($user)
        {
            $params = [];
            $params['openid'] = $user['xcx_openid'];
            $params['Mobile'] = $user['mobile'];
            $params['Userid'] = $user['xcx_openid'];
            $data = $this->scrmRepository->register($params);

        }
        return Success::success_v2(Success::success,$data);

    }

    /**
     * 查询会员信息
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/21
     * Time: 15:36
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function query_member(Request $request)
    {
        $id = $request->input('id',1);
        $data = $this->scrmRepository->query_member($id);
        return Success::success_v2(Success::success,$data);
    }

    /**
     * 更新会员信息
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/21
     * Time: 15:36
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update_member(Request $request)
    {
        $id = $request->input('id',1);
        $data = $this->scrmRepository->update_member($id);
        return Success::success_v2(Success::success,$data);
    }

    /**
     * 优惠券list
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/9/6
     * Time: 16:30
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function coupon_list(Request $request)
    {
        $id = $request->input('id',1);
        $data = $this->scrmRepository->coupon_list();
        return Success::success_v2(Success::success,$data);
    }


    /**
     * 优惠券核销
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/9/6
     * Time: 16:30
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function coupon_write(Request $request)
    {
        $id = $request->input('id',1);
        $data = $this->scrmRepository->coupon_write();
        return Success::success_v2(Success::success,$data);
    }

    /**
     * 积分变动
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/21
     * Time: 16:40
     * @return \Illuminate\Http\JsonResponse
     */
    public function loyalty()
    {
        $data = $this->scrmMiRepository->loyalty();
        return Success::success_v2(Success::success,$data);
    }

    /**
     * 积分查询
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/21
     * Time: 16:45
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function info(Request $request)
    {
        $id = $request->input('id',1);
        $data = $this->scrmMiRepository->info($id);
        return Success::success_v2(Success::success,$data);
    }

    /**
     * 积分历史
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/21
     * Time: 16:45
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request)
    {
        $id = $request->input('id',1);
        $cid = $request->input('cid','');
        $data = $this->scrmMiRepository->list($id,$cid);
        return Success::success_v2(Success::success,$data);
    }

    /**
     * 小票上传
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/26
     * Time: 14:06
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function receipt_add(Request $request)
    {
        $id = $request->input('id',1);
        $data = $this->scrmMiRepository->receipt_add($id);
        return Success::success_v2(Success::success,$data);
    }

    /**
     * 小票历史
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/21
     * Time: 16:59
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function receipt(Request $request)
    {
        $id = $request->input('id',1);
        $data = $this->scrmMiRepository->receipt($id);
        return Success::success_v2(Success::success,$data);
    }
}