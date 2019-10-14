<?php
/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2019/9/9
 * Time: 16:49
 */

namespace App\Http\Controllers\Home\Api\Common;


use App\Http\Controllers\Controller;
use App\Http\Success;
use App\Repository\Home\Common\SelectRepository;
use Illuminate\Http\Request;

class SelectController extends Controller
{
    public $selectRepository;
    public function __construct(SelectRepository $selectRepository)
    {
        $this->selectRepository = $selectRepository;
    }

    /**
     * 门店查询
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/9/9
     * Time: 16:55
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $this->selectRepository->store($request);
        return Success::success_v2(Success::success,$data);
    }

    /**
     * 品牌查询
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/9/9
     * Time: 16:55
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function brand(Request $request)
    {
        $data = $this->selectRepository->brand($request);
        return Success::success_v2(Success::success,$data);
    }

    /**
     * 城市信息查询
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/9/9
     * Time: 16:55
     * @return \Illuminate\Http\JsonResponse
     */
    public function city()
    {
        $data = $this->selectRepository->city();
        return Success::success_v2(Success::success,$data);
    }
}