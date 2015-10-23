<?php

namespace App\Http\Controllers;

use App\Utils\BiliBiliHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Predis\Client;

class HomeController extends Controller
{

    public function home()
    {
        $redis = new Client();

        $index = $redis->hgetall('index');

        $sorts = array_values(BiliBiliHelper::getSorts());

        foreach ($sorts as $sort) {
            $index[$sort] = json_decode($index[$sort], true);
        }

        return view('index')->with('content', $index)->with('sorts', $sorts);
    }


    public function sort($tid, Request $request)
    {
        $sorts = BiliBiliHelper::getSorts();

        //分类非法检测
        if (!array_has($sorts, $tid)) {
            return $this->returnError('分类不存在');
        }

        $order = $request->get('order', 'hot');
        $page = $request->get('page', 1);

        //默认取出redis
        if ($order == 'hot' && $page == 1) {
            $redis = new Client();
            $sort = $redis->hget('sort', $sorts[$tid]);
            $sort = json_decode($sort, true);
        } else {

        }


        return view('sort')->with('content', $sort)->with('tid', $tid)->with('page', $page);
    }

}