<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

/**
 * Created by PhpStorm.
 * User: WhiteBlue
 * Date: 15/7/8
 * Time: 下午2:08
 */
class HasLoginMiddleware
{

    public function handle($request, Closure $next)
    {
        if (Auth::check())
            return redirect('/')->withErrors(array('attempt' => '已经登陆'));;
        return $next($request);
    }

}