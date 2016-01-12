<?php
namespace App\Utils;


class DateUtil
{
    public static function getDate($day_of_week)
    {
        switch ($day_of_week) {
            case('0'):
                return '星期日';
                break;
            case('1'):
                return '星期一';
                break;
            case('2'):
                return '星期二';
                break;
            case('3'):
                return '星期三';
                break;
            case('4'):
                return '星期四';
                break;
            case('5'):
                return '星期五';
                break;
            case('6'):
                return '星期六';
                break;
            default:
                return '其他';
        }
    }

}