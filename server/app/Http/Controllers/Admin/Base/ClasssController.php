<?php

namespace App\Http\Controllers\Admin\Base;

use App\Http\Requests\Admin\Base\ClasssRequest;
use App\Repository\Admin\Base\ClasssRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Success;

class ClasssController extends Controller
{
    public $ClasssRepository;

    public function __construct(ClasssRepository $ClasssRepository)
    {
        $this->ClasssRepository = $ClasssRepository;
    }
    /**
     * list
     */
    public function Classs_list(Request $request)
    {
        $data = $this->ClasssRepository->Classs_list($request);

        return Success::success_v2(Success::success,$data);
    }


    /**
     * 详情
     */
    public function Classs_deta(Request $request)
    {
        $id = $request->input('id','');
        if(!$id) return Success::success_v2(Success::id);

        $data = $this->ClasssRepository->Classs_deta($request);

        return Success::success_v2(Success::success,$data);
    }

    /**
     * 添加
     */
    public function Classs_add(ClasssRequest $request)
    {
        $code = Success::success;

        $re = $this->ClasssRepository->Classs_add($request);

        if($re === false) $code = Success::add;

        return Success::success_v2($code);
    }

    /**
     * 修改
     */
    public function Classs_up(ClasssRequest $request)
    {
        $id = $request->input('id','');
        if(!$id) return Success::success_v2(Success::id);

        $re = $this->ClasssRepository->Classs_up($request);

        $code = $re ? Success::success:Success::update;
        return Success::success_v2($code);
    }

    /**
     * 删除
     */
    public function Classs_de(Request $request)
    {
        $id = $request->input('id','');
        if(!$id) return Success::success_v2(Success::id);
        $re = $this->ClasssRepository->Classs_de($request);
        $code = $re ? Success::success:Success::delete;
        return Success::success_v2($code);
    }
}
