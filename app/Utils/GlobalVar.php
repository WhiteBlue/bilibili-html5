<?php

namespace App\Utils;

/**
 * Created by PhpStorm.
 * User: WhiteBlue
 * Date: 15/7/18
 * Time: 下午4:42
 */
class GlobalVar
{
    public static $CACHED_TIME = 60;
    public static $UPDATE_TIME = 'time';//更新时间

    public static $PAGE_SIZE = 20;//分页大小
    public static $SEARCH_SIZE = 6;//分页大小

    public static $SAVE_CACHE_PRE = 'save';//更新时间
    public static $SORT_CACHE = 'sort';//分类

    public static $NEW_LIST_CACHE = 'new_list';//新番缓存
    public static $INDEX_LIST_CACHE = 'index_list';//首页缓存
    public static $LIST_CACHE = 'list_';//列表缓存
    public static $HOT_CACHE = 'hot_list';

}