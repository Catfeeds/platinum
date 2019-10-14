<?php
/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2019/8/23
 * Time: 16:38
 */

namespace App\Http\Controllers\Home\Api\Receipt;


use App\Http\Controllers\Controller;
use App\Http\Success;
use App\Repository\Home\Receipt\ReceiptRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReceiptController extends Controller
{
    public $receiptRepository;
    public function __construct(ReceiptRepository $receiptRepository)
    {
        $this->receiptRepository = $receiptRepository;
    }

    /**
     * 小票上传
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/23
     * Time: 16:49
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function receipt(Request $request)
    {
        $this->validate($request,[
            'buy_time' => 'required|date',
            'buy_money' => 'required|numeric|min:0|max:1000000',
            'model' => 'required|between:1,30',
            'brand' => 'required|between:1,30',
            'text' => 'nullable|between:0,200',
            'receipt_img' => 'required',
            'product_img' => 'required',
        ]);


        $user = Auth::user();

        $data = $this->receiptRepository->receipt($request,$user);

        return Success::success_v2(Success::success,$data);
    }
}