<?php

namespace App\dao;


use App\Models\Save;
use App\Models\Sort;
use DOMDocument;
use Exception;
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

    private static $APPKEY = '03fc8eb101b091fb';

    static function getUrl($av, $quality)
    {
        try {
            $client = new Client();
            $request = new Request('GET', 'http://interface.bilibili.com/playurl?platform=android&cid=' . $av . '&quality=' . $quality . '&otype=json&appkey=' . BiliGetter::$APPKEY . "&type=mp4");
            $response = $client->send($request, ['timeout' => 2]);

            $json_back = json_decode($response->getBody(), true);

            if ($response->getStatusCode() == '200') {

                if (!$json_back['result'] == 'success')
                    return 1;

                return $json_back;

            } else {
                return 0;
            }
        } catch (Exception $e) {
            return 0;
        }
    }


    /**
     * 得到视频基本信息
     *
     * @param $aid
     * @return bool|mixed
     */
    static function getInfo($aid)
    {
        try {
            $client = new Client();
            $request = new Request('GET', 'http://api.bilibili.cn/view?id=' . $aid . '&appkey=' . BiliGetter::$APPKEY);
            $response = $client->send($request, ['timeout' => 2]);

            if ($response->getStatusCode() == '200') {
                $back_json = json_decode($response->getBody());

                return $back_json;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }


    static function pusher()
    {
        $client = new Client();
        $request = new Request('GET', 'http://api.bilibili.cn/index');
        $response = $client->send($request, ['timeout' => 2]);
        $json = json_decode($response->getBody());

        $list = array();
        foreach ($json as $type => $value) {
            $sort = Sort::where('type', '=', $type)->first();
            if ($sort != null) {
                $temp = array();
                foreach ($value as $id => $content) {
                    if (!is_string($content))
                        array_push($temp, $content);
                }
                $list[$sort->title] = $temp;
            }
        }
        return $list;
    }


    static function getDaily()
    {
        $client = new Client();
        $request = new Request('GET', 'http://api.bilibili.cn/bangumi?appkey=' . BiliGetter::$APPKEY . '&btype=2&weekday=1');
        $response = $client->send($request, ['timeout' => 2]);
        $json = json_decode($response->getBody());

        dd($json);
    }
}