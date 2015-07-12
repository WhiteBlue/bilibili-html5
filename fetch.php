<?php

use App\Events\UpdateEvent;
use App\Models\Save;
use App\Models\Sort;
use Guzzle\Service\Client;
use Guzzle\Http\Message\Request;

/**
 * Created by PhpStorm.
 * User: WhiteBlue
 * Date: 15/7/8
 * Time: 下午10:11
 */

function fetch()
{
    $client = new Client();
    $request = new Request('GET', 'http://api.bilibili.cn/index');
    $response = $client->send($request, ['timeout' => 2]);
    $json = json_decode($response->getBody());

    $count = 0;

    foreach ($json as $type => $value) {
        $sort = Sort::where('type', '=', $type)->first();
        if ($sort != null) {
            foreach ($value as $id => $content) {
                if (is_object($content)) {
                    if (Save::where('aid', '=', $content->aid)->first() == null) {
                        $save = new Save();
                        $save->aid = $content->aid;
                        $save->title = $content->title;
                        if (strlen($content->description) > 70) {
                            $save->content = mb_substr($content->description, 0, 70, 'utf-8') . '....';
                        } else {
                            $save->content = $content->description;
                        }
                        $save->href = 'http://www.bilibili.com/video/AV' . $content->aid;
                        $save->img = $content->pic;
                        $sort->saves()->save($save);
                        $count++;

                        $sort->update = date('Y:m:d');
                        $sort->save();
                    }
                }
            }
        }
    }

    event(new UpdateEvent());

    return $count;
}

$back = fetch();

echo "结果" . $back;