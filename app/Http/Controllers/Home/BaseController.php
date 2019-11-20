<?php

namespace App\Http\Controllers\Home;

use Auth;

class BaseController extends \App\Http\Controllers\Controller {

    protected function guard() {
        return Auth::guard();
    }

}
