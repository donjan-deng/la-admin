<?php

namespace App\Http\Controllers\Api;

use App\Model;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Resources\Users;
use App\Http\Resources\User;

class UserController extends BaseController
{
    //get /users 列表
    public function index(Request $request)
    {
        $params = $request->all();
        $pageSize = $request->input('per_page', 15);
        $list = Model\User::getList($params, $pageSize);
        return new Users($list);
    }

    //创建表单，无用
    public function create()
    {
        //
    }

    //post /users 新建
    public function store(Requests\Manage\User $request)
    {
        //
    }

    // get /users/1  获取单个
    public function show($id)
    {
        return new User(Model\User::findOrFail($id));
    }

    //编辑表单，无用
    public function edit($id)
    {
        //
    }
    // put /users/1  更新
    public function update(Request $request, $id)
    {
        //
    }
    // delete /users/1 删除
    public function destroy($id)
    {
        //
    }
}
