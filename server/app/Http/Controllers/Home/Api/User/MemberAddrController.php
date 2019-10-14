<?php

namespace App\Http\Controllers\Home\Api\User;

use App\Http\Requests\Home\User\MemberAddrRequest;
use App\Http\Success;
use App\Repository\Home\User\MemberAddrRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MemberAddrController extends Controller
{
    public $memberAddrRepository;
    public function __construct(MemberAddrRepository $memberAddrRepository)
    {
        $this->memberAddrRepository = $memberAddrRepository;
    }

    /**
     * 地址list
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/7/18
     * Time: 10:53
     * @return \Illuminate\Http\JsonResponse
     */
    public function member_addr_list()
    {
        $user = Auth::user();

        $data = $this->memberAddrRepository->list($user);

        return Success::success_v2(Success::success,$data);
    }

    /**
     * 添加地址
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/7/18
     * Time: 9:51
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function member_addr_add(MemberAddrRequest $request)
    {
        $user = Auth::user();

        $data = [];

        $data = $this->memberAddrRepository->add($request,$user);

        return Success::success_v2(Success::success,$data);
    }

    /**
     * 修改地址
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/7/18
     * Time: 10:27
     * @param MemberAddrRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function member_addr_up(MemberAddrRequest $request)
    {
        $user = Auth::user();
        $id = $request->input('id','');

        if($this->memberAddrRepository->get_addr($id,$user))
        {
            $this->memberAddrRepository->up($request,$user);

            return Success::success_v2();
        }
        else
        {
            return Success::success_v2(Success::member_addr_up);
        }
    }

    /**
     * 删除地址
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/7/18
     * Time: 10:40
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function member_addr_de(Request $request)
    {
        $user = Auth::user();
        $id = $request->input('id','');
        $this->memberAddrRepository->addr_de($id,$user);

        return Success::success_v2();
    }

    /**
     * 获取地址详情
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/7/18
     * Time: 10:43
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function member_addr_deta(Request $request)
    {
        $user = Auth::user();
        $id = $request->input('id','');
        $data = $this->memberAddrRepository->get_addr($id,$user);

        return Success::success_v2(Success::success,$data);
    }
}
