<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    public $timestamps = false;
    public $primaryKey = 'aid';
    protected $fillable = [
        'aid',
        'title',
        'author',
        'description',
        'created',
        'created_at',
        'face',
        'typename',
        'pages',
        'list'
    ];
}