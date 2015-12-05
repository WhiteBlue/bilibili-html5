<?php
namespace App\Utils;


class BiliBiliHelper
{
    public static $SERVICE_URL = 'http://bili-api.aliapp.com';


    public static function getSorts()
    {
        return [
            '1' => '动画',
            '13' => '番剧',
            '3' => '音乐',
            '129' => '舞蹈',
            '5' => '娱乐',
            '4' => '游戏',
            '36' => '科技',
            '119' => '鬼畜',
            '23' => '电影',
            '11' => '电视剧'
        ];
    }
}