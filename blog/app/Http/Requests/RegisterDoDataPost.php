<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterDoDataPost extends FormRequest
{
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
            'user_email' => [
                'required',
                'unique:blog_user',
                'regex:/^\w+@\w+\.com$/',
            ],
            'code'=>'required|digits:6',
            'user_pwd'=>[
                'required',
                'regex:/^[A-Za-z0-9]{6,12}$/',
            ],
            'repwd' => 'required|same:user_pwd',
        ];
    }
    public function message(){
        return [
            'user_email.required' => '账号不能为空',
            'user_email.unique' => '账号已存在',
            'user_email.regex' => '请输入有效邮箱',
            'code.required' => '验证码不能为空',
            'code.digits' => '验证码必须为6位',
            'user_pwd.required' => '密码不能为空',
            'user_pwd.regex' => '密码必须为6-18位数字或字母',
            'repwd.same' => '确认密码必须和密码一致',
        ];
    }
}
