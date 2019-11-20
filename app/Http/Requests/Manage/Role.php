<?php

namespace App\Http\Requests\Manage;

use Illuminate\Validation\Rule;

class Role extends Base {

    public function rules() {
        return [
            'name' => [
                'bail',
                'required',
                Rule::unique('auth_roles')->ignore($this->input('id',0)),
            ],
            'perms'=>'Required|Array',
        ];
    }

    public function attributes() {
        return [
            'name' => '角色名称'
        ];
    }

    public function messages() {
        return [
            'name.unique' => '角色名称已存在',
        ];
    }

}
