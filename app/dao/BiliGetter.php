<?php

namespace App\dao;


use App\Models\Save;
use App\Models\Sort;
use DOMDocument;
use Guzzle\Http\Message\Request;
use Guzzle\Service\Client;

/**
 * Created by PhpStorm.
 * User: WhiteBlue
 * Date: 15/7/10
 * Time: 上午11:45
 */
class BiliGetter
{
    static $APPKEY = '03fc8eb101b091fb';

    static function getUrl($av)
    {
        $back_json = array();

        $client = new Client();

        $request = new Request('GET', 'http://interface.bilibili.tv/playurl?appkey=' . BiliGetter::$APPKEY . '&cid=' . $av);
        $response = $client->send($request, ['timeout' => 2]);

        $xmlDoc = new DOMDocument();

        $xmlDoc->loadXML($response->getBody());

        $titles = $xmlDoc->getElementsByTagName("durl");

        foreach ($titles as $node) {

            $url = $node->getElementsByTagName('url');

            echo $url[0]->textContent . '<br>';

        }


        $back_json['url'] = xml($response->getBody());

        return $back_json;
    }


    static function pusher()
    {

        date_default_timezone_set('UTC');//时间格式化

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
                        $save = Save::where('aid', '=', $content->aid)->first();

                        if ($save == null) {
                            $save = new Save();
                            $save->aid = $content->aid;
                            $save->title = $content->title;
                            if (strlen($content->description) > 70) {
                                $save->content = mb_substr($content->description, 0, 70, 'utf-8') . '....';
                            } else {
                                $save->content = $content->description;
                            }
                            $save->href = 'http://www.bilibili.com/video/av' . $content->aid;
                            $save->img = $content->pic;
                            $save->author = $content->author;

                            $save->create = $content->create;
                            $save->play = $content->play;


                            $sort->saves()->save($save);

                            $count++;
                        } else {
                            $save->touch();

                            $count++;
                        }
                    }
                }
                $sort->touch();
            }
        }

        return $count;

    }
}