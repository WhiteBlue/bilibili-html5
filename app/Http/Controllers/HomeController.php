<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Utils\BiliBiliHelper;
use App\Utils\RequestUtil;
use DOMDocument;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{

    public function home()
    {
        return view('index');
    }

    public function sort($tid, Request $request)
    {
        return view('sort')->with('tid', $tid);
    }

    public function view($aid, Request $request)
    {
        return view('play')->with('aid', $aid);
    }

    public function search(Request $request)
    {
        return view('search')->with('keyword', $request->get('keyword'));
    }

    public function about()
    {
        return view('about');
    }
}