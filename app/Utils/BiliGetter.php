<?php

namespace App\Utils;


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

    private static $APPKEY = '876fe0ebd0e67a0f';

    private static $SEARCH_KEY = '4ebafd7c4951b366';
    private static $SERKEY = '8cb98205e9b2ad3669aad0fce12a4c13';

    public static function getUrl($av, $quality)
    {
        $client = new Client();
        $request = new Request('GET', 'http://interface.bilibili.com/playurl?platform=android&cid=' . $av . '&quality=' .
            $quality . '&otype=json&appkey=' . BiliGetter::$APPKEY . "&type=mp4");
        $request->setHeader('UserAgent','BiLiBiLi Html5/bili.whiteblue.xyz');
        $response = $client->send($request, ['timeout' => 2]);

        $json_back = json_decode($response->getBody());

        if (!$response->getStatusCode() == '200')
            throw new Exception("Error : Request error...");

        if (!$json_back->result == 'success')
            throw new Exception("Error : Request error...");

        return $json_back;
    }


    /**
     * 得到视频基本信息
     *
     * @param $aid
     * @return bool|mixed
     */
    public static function getInfo($aid)
    {
        $client = new Client();
        $request = new Request('GET', 'http://api.bilibili.cn/view?id=' . $aid . '&appkey=' . BiliGetter::$APPKEY);
        $request->setHeader('UserAgent','BiLiBiLi Html5/bili.whiteblue.xyz');
        $response = $client->send($request, ['timeout' => 2]);

        if (!$response->getStatusCode() == '200')
            throw new Exception("Error : Request error...");


        $back_json = json_decode($response->getBody());

        return $back_json;

    }

    /**
     * 获得首页信息
     *
     * @return array
     */
    public static function getIndex()
    {
        $client = new Client();
        $request = new Request('GET', 'http://api.bilibili.cn/index');
        $request->setHeader('UserAgent','BiLiBiLi Html5/bili.whiteblue.xyz');
        $response = $client->send($request, ['timeout' => 2]);

        if (!$response->getStatusCode() == '200')
            throw new Exception("Error : Request error...");

        $json = json_decode($response->getBody());

        $list = array();

        foreach ($json as $type => $value) {
            $sort = Sort::where('type', '=', $type)->first();
            if ($sort != null) {
                $temp = array();
                $temp['sort'] = $sort;
                $temp['list'] = array();

                foreach ($value as $id => $content) {
                    if (!is_string($content))
                        array_push($temp['list'], $content);
                }

                array_push($list, $temp);
            }
        }
        return $list;
    }

    /**
     * 得到专题
     *
     * @param $spId
     * @throws Exception
     */
    public static function getForNew($spId)
    {
        $client = new Client();
        $request = new Request('GET', 'http://api.bilibili.cn/spview?spid=' . '4016');
        $request->setHeader('UserAgent','BiLiBiLi Html5/bili.whiteblue.xyz');
        $response = $client->send($request, ['timeout' => 2]);

        if (!$response->getStatusCode() == '200')
            throw new Exception("Error : Request error...");

        $json = json_decode($response->getBody());

        dd($json);
    }


    public static function getSearch($content, $page)
    {
        $back = BiliGetter::get_sign(["keyword" => $content, "page" => $page, 'pagesize' => 6], BiliGetter::$SEARCH_KEY, BiliGetter::$SERKEY);

        $client = new Client();
        $request = new Request('GET', 'http://api.bilibili.cn/search?' . $back['params'] . '&sign=' . $back['sign']);
        $request->setHeader('UserAgent','BiLiBiLi Html5/bili.whiteblue.xyz');
        $response = $client->send($request, ['timeout' => 2]);

        if (!$response->getStatusCode() == '200')
            throw new Exception("Error : Request error...");

        $json = json_decode($response->getBody());

        return $json;
    }

    /**
     * 新番列表
     */
    public static function getDaily()
    {
        $client = new Client();
        $request = new Request('GET', 'http://api.bilibili.cn/bangumi?appkey=' . BiliGetter::$APPKEY . '&btype=2');
        $request->setHeader('UserAgent','BiLiBiLi Html5/bili.whiteblue.xyz');
        $response = $client->send($request, ['timeout' => 2]);

        if (!$response->getStatusCode() == '200')
            throw new Exception("Error : Request error...");

        $json = json_decode($response->getBody(), true);

        $back_list = array();

        for ($i = 0; $i < 7; $i++) {
            $back_list[$i] = array();
        }

        $list = $json['list'];

        foreach ($list as $each) {
            $weekday = $each['weekday'];
            array_push($back_list[$weekday], $each);
        }

        return $back_list;
    }

    /**
     * Bilibili的sign加密(改)
     *
     * @param $params
     * @param $app_key
     * @param $secret_key
     * @return array
     */
    private static function get_sign($params, $app_key, $secret_key)
    {
        $_data = array();
        $params['appkey'] = $app_key;

        ksort($params);
        reset($params);

        foreach ($params as $k => $v) {
            $_data[] = $k . '=' . urlencode($v);
        }
        $_sign = implode('&', $_data);
        return array(
            'sign' => strtolower(md5($_sign . $secret_key)),
            'params' => $_sign,
        );
    }


}