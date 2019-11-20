<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Model;
use App\Http\Requests\Manage;
use App\Helpers\Code;

class RoleController extends BaseController
{
    public function getList(Request $request)
    {
        $params = $request->all();
        $pageSize = $request->input('per_page', 15);
        $params['with'] = ['permissions'];
        $list = Model\Role::getList($params, $pageSize);
        return $this->json(success($list));
    }

    public function search(Request $request)
    {
        $params = $request->all();
        $pageSize = $request->input('per_page', 1000);
        $list = Model\Role::getList($params, $pageSize);
        $list = $list->toArray();
        return $this->json(success($list['data']));
    }

    public function edit(Manage\Role $request)
    {
        $data = $request->all();
        $perms = $request->input('perms', []);
        unset($data['perms']);
        $data['id'] || $data['id'] = 0;
        $result = Model\Role::updateOrCreate(['id' => $data['id']], $data);
        $result->permissions()->sync($perms);
        return $this->json(success($result));
    }

    //分配角色
    public function attach(Request $request)
    {
        $user = Model\User::find($request->input('user_id'));
        if (!$user) {
            return $this->json(error(Code::RECORD_NOT_FOUND));
        }
        $roles = $request->input('roles', []);
        $user->roles()->sync($roles);
        return $this->json(success($user));
    }
}
