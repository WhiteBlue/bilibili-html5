<?php

namespace App\Listeners;

use App\Events\UpdateEvent;
use Illuminate\Support\Facades\Cache;

/**
 * Created by PhpStorm.
 * User: WhiteBlue
 * Date: 15/7/10
 * Time: 上午1:53
 */
class UpdateListener extends Listener
{

    public function handle(UpdateEvent $event)
    {
        Cache::forget('index_list');
    }

}