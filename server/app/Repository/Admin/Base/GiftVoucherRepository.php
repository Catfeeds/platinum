<?php

namespace App\Repository\Admin\Base;

use Illuminate\Http\Request;
use App\Models\Admin\GiftVoucher;

class GiftVoucherRepository
{

    /**
     * 添加更改字段
     * @var array
     */
    private $field = [
        'name',
        'stock',
        'sales',
        'integral',
        'cover',
        'imgs',
        'text',
        'is_shelf',
        'start',
        'end'
    ];
    /**
     * list
     */
    public function GiftVoucher_list(Request $request)
    {
        $data = [];

        $paginate = $request->input('paginate',10);
        $name = $request->input('name','');
        $s_id = $request->input('s_id','');     // 店铺id

        $query = GiftVoucher::query();
        $query->orderBy('id','DESC');
//        $query->with('store');

        if($name) $query->where('name','like','%'.$name.'%');
        if($s_id) $query->where('s_id',$s_id);

        $data = $query->paginate($paginate);

        return $data;
    }

    /**
     * 详情
     */
    public function GiftVoucher_deta(Request $request)
    {
        $data = [];
        $model = new GiftVoucher();
        $data = $model->where('id',$request['id'])->first();
        return $data;
    }

    /**
     * 数据处理
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/22
     * Time: 13:30
     * @param $at
     * @return mixed
     */
    private function data_init($at)
    {
        $at['cover'] = img_path_get_re($at['cover']);
        foreach ($at['imgs'] as $k => $v)
        {
            $at['imgs'][$k] = img_path_get_re($v);
        }
        return $at;
    }

    /**
     * 添加
     * Created by PhpStorm.
     * @param Request $request
     * @return bool
     */
    public function GiftVoucher_add(Request $request)
    {
        $re = true;
        $at = $request->all();
        $at = $this->data_init($at);
        $model = new GiftVoucher();

        foreach ($this->field as $v)
        {
            $value = isset($at[$v])?$at[$v]:null;
            $model->$v = $value;
        }

        try {
            $model->save();
            $re = true;
        } catch (\Exception $exception) {
            $re = false;
        }

        return $re;
    }

    /**
     * 修改
     * Created by PhpStorm.
     * @param Request $request
     * @return bool
     */
    public function GiftVoucher_up(Request $request)
    {
        $re = true;
        $at = $request->all();
        $at = $this->data_init($at);
        $id = $at['id'];
        $model = new GiftVoucher();

        $update = [];

        foreach ($this->field as $v)
        {
            $value = isset($at[$v])?$at[$v]:null;
            if($v == 'imgs')
            {
                $update[$v] = json_encode($value);
            }
            else
            {
                $update[$v] = $value;
            }
        }

        try {
            $model->where('id',$id)->update($update);
            $re = true;
        } catch (\Exception $exception) {
            $re = false;
        }

        return $re;
    }

    /**
     * 删除
     * Created by PhpStorm.
     * @param Request $request
     */
    public function GiftVoucher_de(Request $request)
    {
        $re = true;
        $at = $request->all();
        $id = $at['id'];
        $model = new GiftVoucher();
        try {
            $model->where('id',$id)->update([
                'is_shelf' => 1
            ]);
            $re = true;
        } catch (\Exception $exception) {
            $re = false;
        }

        return $re;
    }
}