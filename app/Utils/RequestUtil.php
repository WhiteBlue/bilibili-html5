<?php
namespace App\Utils;


use App\Models\Sort;
use Exception;

class RequestUtil
{

    //超时时间
    const REQUEST_TIMEOUT = 8;


    public static function getUrl($url)
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
            $json_content = json_decode($output, true);

            return [
                'code' => $http_code,
                'content' => $json_content,
            ];
        }
    }


    public static function postUrl($url, $post_data)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

        $output = curl_exec($ch);

        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_errno = curl_errno($ch);
        $curl_error = curl_error($ch);

        if ($curl_errno > 0) {
            //curl错误处理
            throw new Exception($curl_error, $curl_errno);
        } else {
            $json_content = json_decode($output, true);

            return [
                'code' => $http_code,
                'content' => $json_content,
            ];
        }
    }


    public static function normalGetUrl($url)
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

            return $output;
        }
    }


}