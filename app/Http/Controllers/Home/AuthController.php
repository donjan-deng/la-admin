<?php

namespace App\Http\Controllers\Home;

use Session;
use App\Model;
use Jenssegers\Agent\Agent;
use App\Component\WeChat;

class AuthController extends BaseController {

    public function __construct() {
        $this->middleware(function ($request, $next) {
            $agent = new Agent();
            $wxUser = Session::get('wx_user');
//            if ($agent->isMobile() &&
//                    strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false && //微信浏览器
//                    !$wxUser) {
//                Session::put('return_url', url()->current());
//                $url = WeChat::instance()->createOauthUrl(url('home/open/wxauth'));
//                return redirect($url);
//            }
            if ($wxUser) { //微信已登录，自动登录用户
                $user = Model\User::where('open_id', $wxUser['openid'])->where('status', 1)->first();
                if ($user) {
                    $this->guard()->login($user);
                }
            }
            if (!$this->guard()->check()) {
                Session::put('return_url', url()->current());
                return redirect('/home/login');
            }
            return $next($request);
        });
        // Redirect::to('/home/login')->send();
    }

}
