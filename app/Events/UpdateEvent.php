<?php

namespace App\Events;
/**
 * Created by PhpStorm.
 * User: WhiteBlue
 * Date: 15/7/10
 * Time: 上午1:51
 */

class UpdateEvent extends Event
{


    /**
     * UpdateEvent constructor.
     */
    public function __construct($list, $list_daily)
    {
        $this->list = $list;
        $this->list_daily = $list_daily;
    }
}