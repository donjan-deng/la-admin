<?php

namespace App\Http\Controllers\Manage;

use Auth;
use Storage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Model;
use App\Http\Requests\Manage;
use App\Helpers\Code;

class IndexController extends \App\Http\Controllers\Controller
{
    public function index()
    {
        $user = $this->guard()->user();
        $isSuperAdmin = $this->guard()->id() == config('app.super_admin'); //是否超级管理员
        if ($isSuperAdmin) {
            $perms = Model\Permission::all();
        } else {
            $perms = $user->getAllPermissions();
        }
        $menu = Model\Permission::getMenuList(1, 1, $perms->pluck('id')); //左侧菜单
        //输出初始化数据
        $data = success([
            'user' => $user,
            'perms' => $perms,
            'perms_arr'=>$perms->pluck('name'),
            'menu' => $menu,
            'config' => [
                'static' => config('app.static'),
                'url' => config('app.url'),
                'page_size'=>[2,15,30,50]
        ]]);
        return $this->json($data);
    }

    public function login(Manage\LoginForm $request)
    {
        $credentials = [
            'username' => $request->input('username'),
            'password' => $request->input('password'),
            'status' => 1
        ];
        $remember = $request->input('remember', false);
        if ($this->guard()->attempt($credentials, $remember)) {
            $request->session()->regenerate();
            $user = $this->guard()->user();
            $user->last_login_at = Carbon::now();
            $user->save();
            return $this->json(success($user));
        } else {
            return $this->json(error(Code::INCORRECT_PASSWORD));
        }
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();
        return $this->json(success(Code::SUCCESS));
    }

    public function upload(Manage\Upload $request)
    {
        $path = Storage::putFile(Carbon::now()->format('Y/m/d'), $request->file('file'));
        return success($path);
    }

    public function editorUpload(Manage\Upload $request)
    {
        $path = config('app.static') . Storage::putFile(Carbon::now()->format('Y/m/d'), $request->file('upload'));
        $callback = $request->input('CKEditorFuncNum');
        echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($callback,'" . $path . "','');</script>";
        die();
    }

    protected function guard()
    {
        return Auth::guard();
    }
}
