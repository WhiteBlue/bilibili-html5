<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Created by PhpStorm.
 * User: WhiteBlue
 * Date: 15/7/9
 * Time: 上午10:29
 */
class Sort extends Model
{
    protected $table = 'sorts';




    public function saves()
    {
        return $this->hasMany('App\Models\Save', 'sort_id');
    }
}