<?php

namespace App\Http\Controllers\Admin\Base;

use App\Http\Requests\Admin\Base\StoreRequest;
use App\Repository\Admin\Base\StoreRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Success;

class StoreController extends Controller
{
    public $StoreRepository;

    public function __construct(StoreRepository $StoreRepository)
    {
        $this->StoreRepository = $StoreRepository;
    }
    /**
     * list
     */
    public function Store_list(Request $request)
    {
        $data = $this->StoreRepository->Store_list($request);

        return Success::success_v2(Success::success,$data);
    }


    /**
     * 详情
     */
    public function Store_deta(Request $request)
    {
        $id = $request->input('id','');
        if(!$id) return Success::success_v2(Success::id);

        $data = $this->StoreRepository->Store_deta($request);

        return Success::success_v2(Success::success,$data);
    }

    /**
     * 添加
     */
    public function Store_add(StoreRequest $request)
    {
        $code = Success::success;

        $re = $this->StoreRepository->Store_add($request);

        if($re === false) $code = Success::add;

        return Success::success_v2($code);
    }

    /**
     * 修改
     */
    public function Store_up(StoreRequest $request)
    {
        $id = $request->input('id','');
        if(!$id) return Success::success_v2(Success::id);

        $re = $this->StoreRepository->Store_up($request);

        $code = $re ? Success::success:Success::update;
        return Success::success_v2($code);
    }

    /**
     * 删除
     */
    public function Store_de(Request $request)
    {
        $id = $request->input('id','');
        if(!$id) return Success::success_v2(Success::id);
        $re = $this->StoreRepository->Store_de($request);
        $code = $re ? Success::success:Success::delete;
        return Success::success_v2($code);
    }
}
