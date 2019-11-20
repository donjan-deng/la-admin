<?php

namespace App\Http\Requests\Manage;

use Illuminate\Validation\Rule;

class User extends Base
{
    public function rules()
    {
        return [
            'username' => [
                'bail',
                'required',
                'alpha_dash',
                Rule::unique('sys_user')->ignore($this->input('user_id', 0), 'user_id'),
            ],
            'real_name' => 'required',
            'password' => 'sometimes|same:confirm_password',
        ];
    }

    public function attributes()
    {
        return [
            'username' => '用户名',
            'real_name' => '姓名'
        ];
    }

    public function messages()
    {
        return [
            'username.required' => '用户名必填',
            'username.unique' => '用户名已存在',
            'username.alpha_dash' => '用户名只能包含字母和数字,破折号和下划线',
            'real_name.required' => '姓名必填',
            'password.same' => '两次输入的密码不一致',
        ];
    }
}
