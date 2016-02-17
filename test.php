<?php

use App\Utils\BiliBiliHelper;
use App\Utils\RequestUtil;
use Illuminate\Support\Facades\Cache;

$app = require __DIR__ . '/bootstrap/app.php';
date_default_timezone_set('PRC');

try {
    if (\Cache::has('test')) {
        echo '存在chche,读取'.'<br />';
        echo \Cache::get('test');
    } else{
        echo '不存在cache,现在创建'.'<br />';
        $time = \Carbon\Carbon::now()->addMinutes(10);
        $redis = \Cache::add('test', '我是缓存资源', $time);
        echo \Cache::get('test');
    }
    echo 'ok';
} catch (\Exception $e) {
    dd($e);
}

