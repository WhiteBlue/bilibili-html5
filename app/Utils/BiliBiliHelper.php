<?php
namespace App\Utils;


class BiliBiliHelper
{
    public static $SERVICE_URL = 'http://bilibili-service.daoapp.io';

    public static $search_types = [
        'video',
        'upuser',
        'topic',
        'bangumi'
    ];

    public static $sorts = [
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


    public static function getNicoSorts()
    {
        return [
            'all' => 'カテゴリ合算',
            'g_ent2' => 'エンタメ・音楽',
            'g_life2' => '生活・一般・スポ',
            'g_politics' => '政治',
            'g_tech' => '科学・技術',
            'g_culture2' => 'アニメ・ゲーム・絵',
            'g_other' => 'その他',
        ];
    }


    public static function FetchNicoId($str)
    {
        $str = str_replace('sm', '', $str);
        $str = str_replace('so', '', $str);
        return $str;
    }
}