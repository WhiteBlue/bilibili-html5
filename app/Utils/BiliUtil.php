<?php

namespace App\Utils;


use App\Models\Sort;
use Exception;

class BiliUtil
{

    //超时时间
    const REQUEST_TIMEOUT = 8;
    private $app_key = '';

    private $search_key = '';
    private $search_secret = '';


    function __construct()
    {
        //从配置文件初始化
        $this->app_key = env('app_key');
        $this->search_key = env('search_key');
        $this->search_secret = env('search_secret');

        if (trim($this->app_key) == '' || trim($this->search_key) == '' || trim($this->search_secret) == '') {
            throw new Exception('Please check your config file...');
        }
    }


    /**
     * curl模拟get请求
     *
     * @param $url
     * @return mixed
     * @throws Exception
     */
    private function getUrl($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        $output = curl_exec($ch);

        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_errno = curl_errno($ch);
        $curl_error = curl_error($ch);

        if ($curl_errno > 0) {
            //curl错误处理
            throw new Exception($curl_error, $curl_errno);
        } else {
            if ($http_code != 200) {
                //http错误处理
                throw new Exception('Whoops! Connection Failed...');
            }
            $json_content = json_decode($output, true);


            if (isset($json_content['code']) && ($json_content['code'] != '0')) {
                throw new Exception($json_content['code']);
            }

            return $json_content;
        }
    }


    private function postUrl($url, array $post_data)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

        curl_setopt($ch, CURLOPT_TIMEOUT, self::REQUEST_TIMEOUT);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, self::REQUEST_TIMEOUT);

        $output = curl_exec($ch);

        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_errno = curl_errno($ch);
        $curl_error = curl_error($ch);

        curl_close($ch);

        if ($curl_errno > 0) {
            //curl错误处理
            throw new Exception($curl_error, $curl_errno);
        } else {
            if ($http_code != 200) {
                //http错误处理
                throw new Exception('Whoops! Connection Failed...');
            }
            $json_content = json_decode($output, true);

            if (isset($json_content['errcode'])) {
                throw new Exception($json_content['error'], $json_content['errcode']);
            }
            return $json_content;
        }
    }


    /**
     * Bilibili的sign加密(改)
     *
     * @param $params
     * @param $app_key
     * @param $secret_key
     * @return array
     */
    private function get_sign($params, $app_key, $secret_key)
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


    /**
     * 视频信息获取
     *
     * @param $aid
     * @return array
     */
    public function getInfo($aid, $page)
    {
        $request_params = [
            'id' => $aid,
            'page' => $page,
            'appkey' => $this->app_key,
        ];

        $back = $this->getUrl('http://api.bilibili.cn/view?' . http_build_query($request_params));

        return $back;
    }

    /**
     * 得到首页推荐
     *
     * @return array
     */
    public function getIndex()
    {
        $json = $this->getUrl('http://api.bilibili.cn/index');

        $list = array();

        foreach ($json as $type => $value) {
            $sort = Sort::where('type', '=', $type)->first();
            if ($sort != null) {
                $temp = array();
                $temp['sort'] = $sort;
                $temp['list'] = array();

                foreach ($value as $id => $content) {
                    if (!is_string($content)) {
                        array_push($temp['list'], $content);
                    }
                }
                array_pop($temp['list']);

                array_push($list, $temp);
            }
        }

        return $list;
    }

    /**
     * 得到最热视频
     *
     * @return array
     */
    public function getHot()
    {
        $json = $this->getUrl('http://api.bilibili.cn/index');

        $list = array();
        for ($i = 0; $i < 4; $i++) {
            array_push($list, $json['type1'][$i]);
        }

        return $list;
    }


    /**
     * 番剧更新
     *
     * @return array
     */
    public function getDaily()
    {
        $request_params = [
            'btype' => '2',
            'appkey' => $this->app_key,
        ];

        $json = $this->getUrl('http://api.bilibili.cn/bangumi?' . http_build_query($request_params));

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
     * 视频搜素
     *
     * @param $keyword
     * @param $page
     * @return array
     */
    public function getSearch($keyword, $page)
    {
        $sign = $this->get_sign(["keyword" => $keyword, "page" => $page, 'pagesize' => 6], $this->search_key,
            $this->search_secret);

        $json_back = $this->getUrl('http://api.bilibili.cn/search?' . $sign['params'] . '&sign=' . $sign['sign']);

        return $json_back;
    }


    /**
     *
     * 视频分类信息获取(分页)
     *
     * @param $tid
     * @param $order
     * @param $page
     * @param $page_size
     * @return mixed
     * @throws Exception
     */
    public function getPageList($tid, $order, $page, $page_size)
    {
        $request_params = [
            'type' => 'json',
            'page' => $page,
            'pagesize' => $page_size,
            'order' => $order,
            'appkey' => $this->app_key,
            'tid' => $tid,
        ];

        $json = $this->getUrl('http://api.bilibili.cn/list?' . http_build_query($request_params));

        return $json;
    }


    public function getVideo($cid, $quality)
    {
        $request_params = [
            'platform' => 'android',
            'cid' => $cid,
            'quality' => $quality,
            'otype' => 'json',
            'appkey' => $this->app_key,
            'type' => 'mp4',
        ];

        $json = $this->getUrl('http://interface.bilibili.com/playurl?' . http_build_query($request_params));

        return $json;
    }


}


