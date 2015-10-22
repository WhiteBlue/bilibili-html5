<?php

namespace App\Http\Controllers;


use Laravel\Lumen\Routing\Controller;

class BaseController extends Controller
{
    public function returnError(string $msg)
    {
        return view('pusher.error')->with('error_content', $msg);
    }
}