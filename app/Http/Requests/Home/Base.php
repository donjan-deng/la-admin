<?php

namespace App\Http\Requests\Home;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use App\Component\Code;

class Base extends FormRequest {

    public function authorize() {
        return true;
    }
}
