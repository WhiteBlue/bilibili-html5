<?php
/**
 * Created by PhpStorm.
 * User: WhiteBlue
 * Date: 15/7/8
 * Time: 上午12:23
 */

namespace App\Http\Middleware;


use Closure;
use Illuminate\Support\Facades\Auth;

class LoginMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::guest())
            return redirect('auth/login')->with('message', '请先登陆');
        return $next($request);
    }
}
