<?php

use App\Utils\BiliBiliHelper;
use App\Utils\RequestUtil;

$app = require __DIR__ . '/bootstrap/app.php';
date_default_timezone_set('PRC');
try {
    $conn = new MongoClient();
    $db = $conn->selectDB('bilibili');
    $collection = new MongoCollection($db, 'videoIds');
    $collVideos = new MongoCollection($db, 'videos');
    $item = $collection->findOne();
    $startId = empty($item["startId"]) ? 3870000 : intval($item["startId"]);
    $maxId = 0;
    while (true) {
        if ($startId >= $maxId) {
            $maxContent=RequestUtil::getUrlHtml("http://www.bilibili.com/newlist.html");
            if ($maxContent['code'] != 200) {
                sleep(30);
                continue;
            }
            $content = $maxContent['content'];
            $indexEnd=strpos($content,"/\" target=\"_blank\" class=\"preview\">");
            $maxId=substr($content,$indexEnd-7,7);
            $maxId=$maxId-1500;
            sleep(20);
            continue;
        }
        $back = RequestUtil::getUrl(BiliBiliHelper::$SERVICE_URL . "/view/$startId");
        if ($back['code'] != 200) {
            sleep(10);
            $startId++;
            continue;
        }
        $content = $back['content'];
        $content['aid'] = $startId;
        $content["_id"] = $startId;
        $collVideos->save($content);
        $collection->save(array("_id" => 1, "startId" => $startId));
        echo strval($startId).'\n';
        $startId++;
        sleep(8);
    }
} catch (\Exception $e) {
    dd($e);
}

