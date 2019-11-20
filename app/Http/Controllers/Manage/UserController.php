<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Model;
use App\Http\Requests\Manage;
use App\Helpers\Code;

class UserController extends BaseController
{
    public function getList(Request $request)
    {
        $params = $request->all();
        $pageSize = $request->input('per_page', 15);
        $list = Model\User::getList($params, $pageSize);
        return $this->json(success($list));
    }

    public function edit(Manage\User $request)
    {
        $data = $request->all();
        unset($data['confirm_password']);
        $data['user_id'] || $data['user_id'] = 0;
        if ($data['user_id'] > 0) {
            unset($data['username']);
        }
        if ($data['user_id'] == 0 && empty($data['password'])) {
            return $this->json(error(Code::VALIDATE_ERROR, '请填写密码'));
        } elseif ($data['user_id'] > 0 && empty($data['password'])) {
            unset($data['password']);
        } elseif (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }
        $data['remember_token'] = ''; //取消登录
        $result = Model\User::updateOrCreate(['user_id' => $data['user_id']], $data);
        return $this->json(success($result));
    }
}
