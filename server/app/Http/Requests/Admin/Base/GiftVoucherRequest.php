<?php

namespace App\Http\Requests\Admin\Base;

use Illuminate\Foundation\Http\FormRequest;

class GiftVoucherRequest extends FormRequest
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
            'name' => 'required|between:1,50',
            'stock' => 'required|numeric|between:0,1000000',
            'sales' => 'required|numeric|between:0,1000000',
            'integral' => 'required|numeric|between:0,1000000',
            'cover' => 'required|between:1,200',
            'imgs' => 'required|array|between:1,10',
            'text' => 'required|between:1,100000',
            'is_shelf' => 'required|in:1,2',
            'start' => 'required|date',
            'end' => 'required|date',
        ];
    }

    public function messages()
    {
        return [];
    }
}
