<?php

namespace App\Http\Requests\Home\User;

use Illuminate\Foundation\Http\FormRequest;

class MemberAddrRequest extends FormRequest
{
    public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
        $this->validate($request,$this->rules(),$this->messages());
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:2|max:20',
            'mobile' => 'required|min:2|max:20',
            'province' => 'required',
            'city' => 'required',
            'area' => 'required',
            'addr' => 'required',
            'type' => 'nullable|in:0,1'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '联系人不能为空',
            'name.min' => '联系人长度应该在2-20',
            'name.max' => '联系人长度应该在2-20',
            'mobile.required' => '联系电话不能为空',
            'mobile.min' => '联系电话长度应该在2-20',
            'mobile.max' => '联系电话长度应该在2-20',
            'province.required' => '请选择省',
            'city.required' => '请选择市',
            'area.required' => '请选择区',
            'addr.required' => '详细不能为空',
            'type.in' => '默认值只能是0或者1'
        ];
    }
}
