<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Model;
use App\Helpers\Code;

class CheckPermission {

    public function handle($request, Closure $next) {
        $path = $request->path();
        $user = $request->user();
        if ($user->user_id != config('app.super_admin') &&
                !$user->can($path) &&
                Model\Permission::where('name', $path)->count() > 0) {
            throw (new HttpException(Code::DISALLOW, Code::msg(Code::DISALLOW)));
        }
        return $next($request);
    }

}
