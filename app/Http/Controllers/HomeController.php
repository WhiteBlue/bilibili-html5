<?php

namespace App\Http\Controllers;

use App\dao\BiliGetter;
use App\Events\UpdateEvent;
use App\Models\Save;
use App\Models\Sort;
use App\Models\User;
use Guzzle\Service\Client;
use Illuminate\Http\Request as BaseRequest;
use Guzzle\Http\Message\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Laravel\Lumen\Routing\Controller;
use Symfony\Component\Translation\Tests\StringClass;

/**
 * Created by PhpStorm.
 * User: WhiteBlue
 * Date: 15/7/8
 * Time: 下午9:06
 */
class HomeController extends Controller
{


    public function index()
    {
        $list = null;
        if (!Cache::has('index_list')) {
            $list = array();

            foreach (Sort::all() as $sort) {
                $innerList = array();
                $innerList['sort'] = $sort;
                $innerList['list'] = $sort->saves()->orderBy('updated_at', 'desc')->orderBy('create', 'desc')->orderBy('play', 'desc')->take(4)->get();

                array_push($list, $innerList);
            }

            Cache::forever('index_list', $list);
        } else {
            $list = Cache::get('index_list');
        }


        return view('pusher.index')->with('list', $list);
    }


    public function about()
    {
        return view('pusher.about');
    }


    public function aboutMe()
    {
        return view('pusher.aboutMe');
    }


    public function catchUrl()
    {
        $back = BiliGetter::getUrl(567824);

        $html = file_get_html($back->offsite);

        dd($html);

        // Find all images
        foreach ($html->find('img') as $element)
            echo $element->src . '<br>';
    }


    //定时任务
    public function pump()
    {
        $count = BiliGetter::pusher();

        event(new UpdateEvent());

        return 'update : ' . $count . ' saves.';
    }

}




