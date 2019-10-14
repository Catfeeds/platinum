<?php
/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2019/8/28
 * Time: 10:42
 */

namespace App\Http\Controllers\Ext;


use App\Http\Controllers\Controller;
use App\Http\Success;
use App\Repository\Home\Receipt\ReceiptRepository;
use App\User;
use Illuminate\Http\Request;

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
     * Date: 2019/8/28
     * Time: 11:08
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function receipt_add(Request $request)
    {
        $this->validate($request,[
            'buy_time' => 'required|date',
            'buy_money' => 'required|numeric|min:0|max:1000000',
            'model' => 'required|between:1,30',
            'brand' => 'required|between:1,30',
            'text' => 'nullable|between:0,200',
            'receipt_img' => 'required|between:0,250',
            'product_img' => 'required|between:0,250',
            'u_id' => 'required|numeric',
        ]);

        $user = User::find($request->input('u_id',''));
        if($user)
        {
            $id = $this->receiptRepository->receipt($request,$user);
            return Success::success_ext(Success::success,$id);
        }
        return Success::success_ext(Success::receipt_add_fail);
    }

    /**
     * 小票list
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/28
     * Time: 10:58
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function receipt_list(Request $request)
    {
        $data = $this->receiptRepository->receipt_list($request);

        return Success::success_ext(Success::success,$data);
    }

}