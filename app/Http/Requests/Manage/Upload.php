<?php

namespace App\Http\Requests\Manage;

use Illuminate\Validation\Rule;

class Upload extends Base {

    public function rules() {
        return [
            'file' => [
                'file',
                'image',
                'max:' . (5 * 1024 * 1024) //5M
            ]
        ];
    }

    public function attributes() {
        return [
            //'file' => '文件',
        ];
    }

    public function messages() {
        return [
            'file.max' => '文件超过5M',
            'file.image' => '只能上传图片',
            'file.file' => '不正确的文件',
        ];
    }

}
