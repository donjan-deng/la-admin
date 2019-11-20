<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Model;
use App\Http\Requests\Manage;
use App\Helpers\Code;

class PermissionController extends BaseController
{
    public function search(Request $request)
    {
        $list = Model\Permission::getMenuList();
        return $this->json(success($list));
    }
}
