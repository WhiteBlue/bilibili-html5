<?php

namespace App\Http\Middleware;

use App\Utils\CacheSetter;
use Closure;

/**
 *
 * 缓存检测刷新
 *
 * Class CacheMiddware
 * @package App\Http\Middleware
 */
class CacheMiddleware
{

    public function handle($request, Closure $next)
    {
        if (!CacheSetter::hasCache()) {
            CacheSetter::freshCache();
        }

        return $next($request);
    }

}