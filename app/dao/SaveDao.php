<?php

namespace App\Dao;

use App\Models\Save;
use App\Utils\CacheSetter;
use App\Utils\GlobalVar;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

/**
 * Created by PhpStorm.
 * User: WhiteBlue
 * Date: 15/7/18
 * Time: 下午4:36
 */
class SaveDao
{
    public static function getSave($aid)
    {
        $back_save = Save::where('aid', '=', $aid)->first();
        return $back_save;
    }


    public static function saveNew($json, $aid)
    {

        $save = new Save();

        $save->aid = $aid;

        $save->mid = $json->mid;
        $save->cid = $json->cid;
        $save->typename = $json->typename;
        $save->title = $json->title;
        $save->play = $json->play;
        $save->review = $json->review;
        $save->video_review = $json->video_review;
        $save->favorites = $json->favorites;
        $save->coins = $json->coins;
        $save->pages = $json->pages;
        $save->author = $json->author;
        $save->face = $json->face;
        $save->description = $json->description;
        $save->tag = $json->tag;
        $save->pic = $json->pic;
        $save->created_at = date_create($json->created_at);
        $save->offsite = $json->offsite;


        $save->save();


        return $save;
    }

}