<?php

namespace App\Http\Controllers\Home\Api\User;

use App\Http\Requests\UserRequest;
use App\Http\Success;
use App\Models\Home\Voucher;
use App\Repository\Home\Store\StoreRepository;
use App\Repository\Home\User\UserRepository;
use App\Repository\Home\Voucher\VoucherOrderRepository;
use App\Repository\Home\Voucher\VoucherRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public $userRepository;
    public $voucherRepository;
    public function __construct(UserRepository $userRepository,VoucherRepository $voucherRepository)
    {
        $this->userRepository = $userRepository;
        $this->voucherRepository = $voucherRepository;
    }

    /**
     * 积分历史
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/22
     * Time: 16:20
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function integral(Request $request)
    {
        $user = Auth::user();

        $data = $this->userRepository->integral($request,$user);

        return Success::success_v2(Success::success,$data);
    }

    /**
     * 用户详细信息
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/22
     * Time: 16:23
     * @return \Illuminate\Http\JsonResponse
     */
    public function userinfo()
    {
        $user = Auth::user();

        $data = $this->userRepository->userinfo($user);

        return Success::success_v2(Success::success,$data);
    }

    /**
     * 用户详细信息修改
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/23
     * Time: 15:38
     * @param UserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function user_detail(UserRequest $request)
    {
        $user = Auth::user();

        $data = $this->userRepository->user_detail($request,$user);

        return Success::success_v2(Success::success,$data);
    }

    /**
     * 修改基础信息
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/23
     * Time: 15:43
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function user_base(Request $request)
    {
        $user = Auth::user();

        $data = $this->userRepository->user_base($request,$user);

        return Success::success_v2(Success::success,$data);
    }

    /**
     * 用户签到
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/23
     * Time: 16:11
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sign_in(Request $request)
    {
        $user = Auth::user();
        $code = Success::success;

        $re = $this->userRepository->sign_in($user);

        if($re === false)
        {
            $code = Success::sign_in;
        }
        else if($re === '已签到')
        {
            $code = Success::sign_in_re;
        }

        return Success::success_v2($code);
    }

    /**
     * 用户签到list
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/23
     * Time: 16:17
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sign_list(Request $request)
    {
        $user = Auth::user();
        $data = $this->userRepository->sign_list($request,$user);
        return Success::success_v2(Success::success,$data);
    }

    /**
     * 用户注册电子券领取
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/9/10
     * Time: 11:33
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function user_register_voucher(Request $request)
    {
        $at = $this->validate($request,[
            'id' => 'required'
        ],[
            'id.required' => '请选择门店',
        ]);
        $user = Auth::user();
        $s_id = $at['id'];
        $num = 1;
        $voucherRepository = $this->voucherRepository;

        // 验证门店券数量
        if(!StoreRepository::stores_voucher_num($s_id,(-$num)))
        {
            return Success::success_v2(Success::user_register_voucher_store);
        }

        // 验证用户是否已领取
        if($user->get_store_voucher)
        {
            return Success::success_v2(Success::user_register_voucher_is);
        }

        // 电子券
        $voucher = Voucher::find(1);

        // 验证库存
        if($voucherRepository->stock_is($voucher,1))
        {
            // 存储到电子券订单表
            $request->request->set('num',$num);
            $request->request->set('v_id',$voucher['id']);
            VoucherOrderRepository::order($request,$user,$voucher,$s_id);
        }
        else
        {
            return Success::success_v2(Success::user_register_voucher_stock);
        }

        return Success::success_v2(Success::success);
    }
}
