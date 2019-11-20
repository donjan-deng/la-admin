<?php

namespace App\Http\Controllers\Manage;

use Auth;

class BaseController extends \App\Http\Controllers\Controller {

    public function __construct() {
        
    }

    protected function guard() {
        return Auth::guard();
    }

}
