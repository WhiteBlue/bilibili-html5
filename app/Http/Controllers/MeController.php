<?php

namespace App\Http\Controllers;
/**
 * Created by PhpStorm.
 * User: WhiteBlue
 * Date: 15/7/9
 * Time: 下午12:04
 */

class MeController extends Controller
{

    public function index()
    {
        return view('pusher.me');
    }


}