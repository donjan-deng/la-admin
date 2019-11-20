<?php

namespace App\Http\Requests\Manage;

use Illuminate\Validation\Rule;

class Profile extends Base {

    public function rules() {
        return [
            'phone' => [
                'bail',
                'required',
                Rule::unique('mch_user')->ignore($this->input('user_id', 0), 'user_id'),
            ],
            'password' => 'sometimes|same:confirm_password',
        ];
    }

    public function attributes() {
        return [
            'username' => '用户名',
            'real_name' => '姓名',
            'phone' => '手机号'
        ];
    }

    public function messages() {
        return [
            'username.unique' => '用户名已存在',
            'phone.unique' => '手机号已存在',
            'password.same' => '两次输入的密码不一致',
        ];
    }

}
