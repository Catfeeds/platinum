<?php

namespace App\Repository\Admin\Base;

use Illuminate\Http\Request;
use App\Models\Admin\Classs;

class ClasssRepository
{

    /**
     * 添加更改字段
     * @var array
     */
    private $field = [
        'name',
        'type'
    ];

    /**
     * list
     */
    public function Classs_list(Request $request)
    {
        $data = [];

        $paginate = $request->input('paginate',10);
        $name = $request->input('name','');

        $query = Classs::query();
        $query->orderBy('id','DESC');
        if($name) $query->where('name','like','%'.$name.'%');


        $data = $query->paginate($paginate);

        return $data;
    }

    /**
     * 详情
     */
    public function Classs_deta(Request $request)
    {
        $data = [];
        $model = new Classs();
        $data = $model->where('id',$request['id'])->first();
        return $data;
    }

    /**
     * 添加
     * Created by PhpStorm.
     * @param Request $request
     * @return bool
     */
    public function Classs_add(Request $request)
    {
        $re = true;
        $at = $request->all();
        $model = new Classs();

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
    public function Classs_up(Request $request)
    {
        $re = true;
        $at = $request->all();
        $id = $at['id'];
        $model = new Classs();

        $update = [];

        foreach ($this->field as $v)
        {
            $value = isset($at[$v])?$at[$v]:null;
            $update[$v] = $value;
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
    public function Classs_de(Request $request)
    {
        $re = true;
        $at = $request->all();
        $id = $at['id'];
        $model = new Classs();
        try {
            $model->where('id',$id)->delete();
            $re = true;
        } catch (\Exception $exception) {
            $re = false;
        }

        return $re;
    }
}