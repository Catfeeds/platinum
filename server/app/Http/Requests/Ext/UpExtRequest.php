<?php

namespace App\Http\Requests\Ext;

use Illuminate\Foundation\Http\FormRequest;

class UpExtRequest extends FormRequest
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
            'id' => 'required|numeric',
            'age' => 'nullable|numeric|min:0|max:100',
            'memorial_day_name' => 'nullable|between:1,30',
            'memorial_date' => 'nullable|date',
            'constellation' => 'nullable|between:1,10',
            'job' => 'nullable|between:1,10',
            'salary' => 'nullable|numeric|min:0|max:10000000',
            'is_marr' => 'nullable|in:1,2',
            'is_sub' => 'nullable|in:1,2',
            'sex' => 'nullable|in:1,2',
            'full_name' => 'nullable|between:1,20',
            'birthday' => 'nullable|date',
            'wechat_follow_date' => 'nullable|date',
            /**
             * 用户表
             */
            'name' => 'nullable|between:1,30',              //  微信昵称
            'avatarurl' => 'nullable|between:1,250',              // 头像
            'member_nickname' => 'nullable|between:1,30',        // 会员昵称
            'get_info_by_sms' => 'nullable|in:1,2',
            'email' => 'nullable|between:1,50',
            'zip' => 'nullable|between:1,6',
            'addr' => 'nullable|between:1,50',
            'province' => 'nullable|between:1,40',
            'city' => 'nullable|between:1,40',
            'area' => 'nullable|between:1,40',
            'source' => 'nullable|between:1,30',
        ];
    }
}
