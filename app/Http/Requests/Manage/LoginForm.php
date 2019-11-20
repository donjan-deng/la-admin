<?php

namespace App\Http\Requests\Manage;

use Illuminate\Validation\Rule;
use App\Rules;

class LoginForm extends Base {

    public function rules() {
        return [
            'username' => ['bail','required'],
            'password' => ['bail','required'],
            'captcha' => ['bail','required',new Rules\TestCaptcha()],
        ];
    }

    public function attributes() {
        return [
            'username' => '用户名',
            'password' => '密码',
            'captcha' => '验证码',
        ];
    }

    public function messages() {
        return [
        ];
    }

}
