<?php
/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2019/8/23
 * Time: 16:39
 */

namespace App\Repository\Home\Receipt;


use App\Models\Home\Receipt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReceiptRepository
{
    /**
     * 小票上传
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/23
     * Time: 16:49
     * @param Request $request
     * @param $user
     * @return bool
     */
    public function receipt(Request $request,$user)
    {
        $re = true;
        $at = $request->all();
        $at = $this->data_init($at);
        $model = new Receipt();
        try {
            $model->buy_time = $at['buy_time'];
            $model->buy_money = $at['buy_money'];
            $model->model = $at['model'];
            $model->brand = $at['brand'];
            if(isset($at['text'])) $model->text = $at['text'];
            $model->receipt_img = $at['receipt_img'];
            $model->product_img = $at['product_img'];
            $model->u_id = $user['id'];
            $model->is_exper = 2;
            $model->state = 1;
            $model->save();
            $re = $model->id;
        } catch (\Exception $exception) {
            Log::info('receipt:'.$exception->getMessage());
            $re = false;
        }

        return $re;
    }

    /**
     * 提交数据初始化
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/23
     * Time: 16:56
     * @param $at
     * @return mixed
     */
    private function data_init($at)
    {
        $at['receipt_img'] = img_path_get_re($at['receipt_img']);
        $at['product_img'] = img_path_get_re($at['product_img']);
        return $at;
    }

    /**
     * 小票list
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/28
     * Time: 10:56
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function receipt_list(Request $request)
    {
        $u_id = $request->input('id','');
        $paginate = $request->input('paginate','');

        $model = Receipt::query();

        $model->where('u_id',$u_id);
        $model->orderBy('id');
        $data = $model->paginate($paginate);
        return $data;
    }
}