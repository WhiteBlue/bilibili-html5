<?php

namespace App\Listeners;

use App\Events\UpdateEvent;
use App\Utils\CacheSetter;
use Illuminate\Support\Facades\Cache;

/**
 *
 * 监听刷新事件
 *
 * Class UpdateListener
 * @package App\Listeners
 */
class UpdateListener extends Listener
{

    public function handle(UpdateEvent $event)
    {
        CacheSetter::freshCache();
    }

}