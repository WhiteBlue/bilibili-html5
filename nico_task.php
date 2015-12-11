<?php

use App\Utils\BiliBiliHelper;
use App\Utils\RequestUtil;
use Illuminate\Support\Facades\Cache;


$app = require __DIR__ . '/bootstrap/app.php';

$sort_list = [];

foreach (BiliBiliHelper::getNicoSorts() as $key => $value) {
    $back = RequestUtil::normalGetUrl('http://www.nicovideo.jp/ranking/fav/hourly/' . $key . '?rss=2.0&lang=ja-jp');

    $xmlDoc = new DOMDocument();
    $xmlDoc->loadXML($back);

    $element = $xmlDoc->documentElement;
    $chanel = $element->getElementsByTagName('channel')->item(0);

    $video_array = [];

    foreach ($chanel->getElementsByTagName('item') as $item) {
        $inner = [];
        $inner['title'] = explode('：', $item->getElementsByTagName('title')[0]->nodeValue)[1];
        $inner['id'] = explode('watch/', $item->getElementsByTagName('link')[0]->nodeValue)[1];
        array_push($video_array, $inner);
    }
    $sort_list[$key] = $video_array;
}

Cache::forever('nico_cache', $sort_list);

dd('ok');
