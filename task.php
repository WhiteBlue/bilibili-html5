<?php

use App\Utils\BiliBiliHelper;
use App\Utils\RequestUtil;
use Illuminate\Support\Facades\Cache;

$app = require __DIR__ . '/bootstrap/app.php';
date_default_timezone_set('PRC');

try {
    $sort_list = [];
    foreach (BiliBiliHelper::getSorts() as $key => $value) {
        $request_array = [
            'tid' => $key,
            'order' => 'hot',
            'page' => '1',
            'pagesize' => '20'
        ];
        $back = RequestUtil::getUrl(BiliBiliHelper::$SERVICE_URL . '/sort?' . http_build_query($request_array));
        $sort_list[$key] = $back['content'];
    }

    $index = RequestUtil::getUrl(BiliBiliHelper::$SERVICE_URL . '/index');
    $refresh_time = date('H:i:s');

    $bangumi = RequestUtil::getUrl(BiliBiliHelper::$SERVICE_URL . '/bangumi?type=2');
    $bangumi_result = [];

    for ($i = 0; $i < 7; $i++) {
        $day_bangumi = [];
        $bangumi_result[$i] = $day_bangumi;
    }

    foreach ($bangumi['content']['list'] as $animation) {
        if (isset($animation['cover'])) {
            array_push($bangumi_result[$animation['weekday']], $animation);
        }
    }

    Cache::forever('index_cache', $index['content']);
    Cache::forever('sort_cache', $sort_list);
    Cache::forever('refresh_time', $refresh_time);
    Cache::forever('bangumi_cache', $bangumi_result);

    dd('ok');
} catch (\Exception $e) {
    dd($e);
}

