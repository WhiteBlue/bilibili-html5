<?php

use App\Utils\BiliBiliHelper;
use App\Utils\RequestUtil;

$app = require __DIR__ . '/bootstrap/app.php';
date_default_timezone_set('PRC');

echo 'start\n';
$conn = new MongoClient();
$db = $conn->selectDB('bilibili');
$collection = new MongoCollection($db, 'videoIds');
$collVideos = new MongoCollection($db, 'videos');
$item = $collection->findOne();
$startId = empty($item["startId"]) ? 3870000 : intval($item["startId"]);
$maxId = 0;
echo strval($startId) . '\n';
while (true) {
    try {
        while (true) {
            if ($startId >= $maxId) {
                $newMaxId = $startId + 1000;
                $back = RequestUtil::getUrl(BiliBiliHelper::$SERVICE_URL . "/view/$newMaxId");
                if ($back['code'] == 200) {
                    $maxId = $newMaxId;
                } else {
                    echo 'sleep-1-20s \n';
                    sleep(20);
                    $startId++;
                }
                echo 'sleep-2-10s \n';
                sleep(10);
                continue;
            }
            $back = RequestUtil::getUrl(BiliBiliHelper::$SERVICE_URL . "/view/$startId");
            if ($back['code'] != 200) {
                echo 'sleep-3-10s \n';
                sleep(10);
                $startId++;
                continue;
            }
            echo strval($startId) . '\n';
            $content = $back['content'];
            $content['aid'] = $startId;
            $content["_id"] = $startId;
            $collVideos->save($content);
            $collection->save(array("_id" => 1, "startId" => $startId));
            $startId++;
            sleep(8);
        }
    } catch (\Exception $e) {
        dd($e);
    }
    sleep(60);
}


