<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

/**
 * Created by PhpStorm.
 * User: WhiteBlue
 * Date: 15/7/9
 * Time: 下午1:46
 */


class BaseLoginMiddleware
{

    public function handle($request, Closure $next)
    {
        return Auth::onceBasic() ?: $next($request);
    }

}