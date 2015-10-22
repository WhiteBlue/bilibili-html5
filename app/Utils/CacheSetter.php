<?php

namespace App\Utils;

use App\Models\Sort;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

/**
 *
 * 缓存工具类
 *
 * Class CacheSetter
 * @package App\Utils
 */
class CacheSetter
{
    public function setCache()
    {

    }


    //设置首页缓存
    private static function setIndexCache()
    {
        try {
            $bili_util = new BiliUtil();

            return $bili_util->getIndex();
        } catch (\Exception $e) {
            return false;
        }
    }

    //设置新番缓存
    private static function setNewsCache()
    {
        try {
            $bili_util = new BiliUtil();

            return $bili_util->getDaily();
        } catch (\Exception $e) {
            return false;
        }
    }


    //刷新静态缓存
    public static function freshCache()
    {
        date_default_timezone_set('PRC');

        $list_index = self::setIndexCache();
        $list_news = self::setNewsCache();

        if ($list_index) {
            Cache::forever(GlobalVar::$INDEX_LIST_CACHE, $list_index);
        }

        if ($list_news) {
            Cache::forever(GlobalVar::$NEW_LIST_CACHE, $list_news);
        }

        Cache::forever(GlobalVar::$UPDATE_TIME, date('H:m:s'));
    }


    //判断静态缓存
    public static function hasCache()
    {
        if (Cache::has(GlobalVar::$INDEX_LIST_CACHE) && Cache::has(GlobalVar::$NEW_LIST_CACHE)) {
            return true;
        } else {
            return false;
        }
    }


    //分类缓存
    public static function getSort()
    {
        if (Cache::has(GlobalVar::$SORT_CACHE)) {
            return Cache::get(GlobalVar::$SORT_CACHE);
        } else {
            $sorts = Sort::all();
            Cache::forever(GlobalVar::$SORT_CACHE, $sorts);
            return $sorts;
        }
    }


    public static function getHot()
    {
        if (!Cache::has(GlobalVar::$HOT_CACHE)) {
            $bili_util = new BiliUtil();

            $hot_list = $bili_util->getHot();

            Cache::add(GlobalVar::$HOT_CACHE, $hot_list, 60 * 5);
        } else {
            $hot_list = Cache::get(GlobalVar::$HOT_CACHE);
        }

        return $hot_list;
    }


}