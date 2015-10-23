<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function returnError($message)
    {
        return redirect('/')->with('message', $message);
    }
}
