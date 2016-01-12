<?php

use App\Utils\BiliBiliHelper;
use App\Utils\RequestUtil;
use Illuminate\Support\Facades\Cache;

$app = require __DIR__ . '/bootstrap/app.php';
date_default_timezone_set('PRC');

try {
    $sort_list = [];
    foreach (BiliBiliHelper::$sorts as $key => $value) {
        $request_array = [
            'order' => 'hot',
            'page' => '1',
            'count' => '16'
        ];
        $back = RequestUtil::getUrl(BiliBiliHelper::$SERVICE_URL . "/sort/$key?" . http_build_query($request_array));
        if ($back['code'] != 200) {
            throw new Exception;
        }
        $sort_list[$key] = $back['content'];
    }

    $index = RequestUtil::getUrl(BiliBiliHelper::$SERVICE_URL . '/topinfo');
    $refresh_time = date('H:i:s');

    $bangumi = RequestUtil::getUrl(BiliBiliHelper::$SERVICE_URL . '/bangumi');

    if ($bangumi['code'] != 200) {
        throw new Exception;
    }
    $bangumi = $bangumi['content'];

    Cache::forever('index_cache', $index['content']);
    Cache::forever('sort_cache', $sort_list);
    Cache::forever('bangumi_cache', $bangumi);
    Cache::forever('refresh_time', $refresh_time);

    echo 'ok';
} catch (\Exception $e) {
    dd($e);
}

