<?php

namespace App\Http\Controllers\Admin\Base;

use App\Http\Requests\Admin\Base\GiftVoucherRequest;
use App\Repository\Admin\Base\GiftVoucherRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Success;

class GiftVoucherController extends Controller
{
    public $GiftVoucherRepository;

    public function __construct(GiftVoucherRepository $GiftVoucherRepository)
    {
        $this->GiftVoucherRepository = $GiftVoucherRepository;
    }
    /**
     * list
     */
    public function GiftVoucher_list(Request $request)
    {
        $data = $this->GiftVoucherRepository->GiftVoucher_list($request);

        return Success::success_v2(Success::success,$data);
    }


    /**
     * 详情
     */
    public function GiftVoucher_deta(Request $request)
    {
        $id = $request->input('id','');
        if(!$id) return Success::success_v2(Success::id);

        $data = $this->GiftVoucherRepository->GiftVoucher_deta($request);

        return Success::success_v2(Success::success,$data);
    }

    /**
     * 添加
     */
    public function GiftVoucher_add(GiftVoucherRequest $request)
    {
        $code = Success::success;

        $re = $this->GiftVoucherRepository->GiftVoucher_add($request);

        if($re === false) $code = Success::add;

        return Success::success_v2($code);
    }

    /**
     * 修改
     */
    public function GiftVoucher_up(GiftVoucherRequest $request)
    {
        $id = $request->input('id','');
        if(!$id) return Success::success_v2(Success::id);

        $re = $this->GiftVoucherRepository->GiftVoucher_up($request);

        $code = $re ? Success::success:Success::update;
        return Success::success_v2($code);
    }

    /**
     * 删除
     */
    public function GiftVoucher_de(Request $request)
    {
        $id = $request->input('id','');
        if(!$id) return Success::success_v2(Success::id);
        $re = $this->GiftVoucherRepository->GiftVoucher_de($request);
        $code = $re ? Success::success:Success::delete;
        return Success::success_v2($code);
    }
}
