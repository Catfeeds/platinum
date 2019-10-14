<?php

namespace App\Repository\Admin\Base;

use Illuminate\Http\Request;
use App\Models\Admin\Store;

class StoreRepository
{

    /**
     * 添加更改字段
     * @var array
     */
    private $field = [
        'name',
        'delete',
        'addr'
    ];

    /**
     * list
     */
    public function Store_list(Request $request)
    {
        $data = [];

        $paginate = $request->input('paginate',10);
        $name = $request->input('name','');

        $query = Store::query();
        $query->orderBy('id','DESC');

        if($name) $query->where('name','like','%'.$name.'%');


        $data = $query->paginate($paginate);

        return $data;
    }

    /**
     * 详情
     */
    public function Store_deta(Request $request)
    {
        $data = [];
        $model = new Store();
        $data = $model->where('id',$request['id'])->first();
        return $data;
    }

    /**
     * 添加
     * Created by PhpStorm.
     * @param Request $request
     * @return bool
     */
    public function Store_add(Request $request)
    {
        $re = true;
        $at = $request->all();
        $model = new Store();


        foreach ($this->field as $v)
        {
            $model->$v = $at[$v];
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
    public function Store_up(Request $request)
    {
        $re = true;
        $at = $request->all();
        $id = $at['id'];
        $model = new Store();

        $update = [];

        foreach ($this->field as $v)
        {
            $update[$v] = $at[$v];
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
    public function Store_de(Request $request)
    {
        $re = true;
        $at = $request->all();
        $id = $at['id'];
        $model = new Store();
        try {
            $model->where('id',$id)->update([
                'delete' => 1
            ]);
            $re = true;
        } catch (\Exception $exception) {
            $re = false;
        }

        return $re;
    }
}