<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function __construct(array $query = [], array $request = [],
                                array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
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
            /**
             * 用户详情表
             */
            'age' => 'required|numeric|min:0|max:100',
            'memorial_day_name' => 'nullable|between:1,30',
            'memorial_date' => 'nullable|date',
            'constellation' => 'nullable|between:1,10',
            'job' => 'required|between:1,10',
            'salary' => 'nullable|numeric|min:0|max:10000000',
            'is_marr' => 'required|in:1,2',
            'is_sub' => 'required|in:1,2',
            'sex' => 'required|in:1,2',
            'full_name' => 'required|between:1,20',
            'birthday' => 'required|date',
            /**
             * 用户表
             */
            'get_info_by_sms' => 'required|in:1,2',
            'email' => 'required|between:1,50',
            'zip' => 'required|between:1,6',
            'addr' => 'required|between:1,50',
            'province' => 'required|between:1,40',
            'city' => 'required|between:1,40',
            'area' => 'required|between:1,40',
        ];
    }
}
