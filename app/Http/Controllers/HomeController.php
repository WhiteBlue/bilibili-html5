<?php

namespace App\Http\Controllers;

use App\Dao\DataAccess;
use App\Utils\BiliGetter;
use App\Events\UpdateEvent;
use App\Models\Save;
use App\Models\Sort;
use App\Models\User;
use App\Utils\CacheSetter;
use App\Utils\GlobalVar;
use Carbon\Carbon;
use DoctrineTest\InstantiatorTestAsset\ExceptionAsset;
use Exception;
use Guzzle\Service\Client;
use Illuminate\Http\Request as BaseRequest;
use Guzzle\Http\Message\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
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

    /**
     * 首页
     * @return $this
     */
    public function index()
    {
        try {
            if (!CacheSetter::hasCache()) {
                CacheSetter::freshCache();
            }

            $index_list = CacheSetter::getIndex();

            $time = CacheSetter::getTime();

            return view('pusher.index')->with('list', $index_list)->with('time', $time);

        } catch (Exception $e) {
            abort(500);
        }
    }


    /**
     * 关于
     * @return \Illuminate\View\View
     */
    public function about()
    {
        return view('pusher.about');
    }


    /**
     * 视频获取ajax
     *
     * @param $aid
     * @param $quality
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function play($aid, $quality)
    {
        try {
            $back = BiliGetter::getUrl($aid, $quality);

            if (!$back) {
                return response()->json(false);
            }

            $json = array();

            $json['mode'] = $quality;
            $json['url'] = $back->durl[0]->url;
            $json['from'] = $back->from;

            return response()->json($json);


        } catch (Exception $e) {
            abort(500);
        }
    }


    /**
     * 视频播放
     *
     * @param $aid
     * @return $this
     */
    public function info($aid)
    {
        try {
            $aid = str_replace('av', '', trim(strtolower($aid)));


            if (strlen($aid) > 10 || strlen($aid) < 4) {
                return redirect('/')->with('message', 'AV号不大对吧');
            }


            $result = DataAccess::getSave($aid);

            if ($result == null) {
                $result = BiliGetter::getInfo($aid);

                if (isset($result->message) || isset($result->code)) {
                    return redirect('/')->with('message', '视频不存在的说');
                }

                $result = DataAccess::saveNew($result, $aid);
            }

            return view('pusher.play')->with('info', $result)->with('aid', $aid);

        } catch (Exception $e) {
            abort(404);
        }
    }


    /**
     * 新番获取
     *
     * @return $this
     * @throws Exception
     */
    public function getNews()
    {
        try {

            if (!CacheSetter::hasCache()) {
                CacheSetter::freshCache();
            }

            $back_json = CacheSetter::getNews();

            date_default_timezone_set('PRC');

            $weekday = date('w');

            $time = CacheSetter::getTime();

            return view('pusher.new')->with('list', $back_json)->with("weekday", $weekday)->with('time', $time);

        } catch (Exception $e) {
            abort(404);
        }
    }


    /**
     * 分区信息
     *
     * @return $this
     */
    public function getList()
    {
        try {
            $mid = Input::get('mid');
            $page = Input::get('page', 1);

            if ($page == 1) {
                if (Cache::has(GlobalVar::$LIST_CACHE . $mid)) {
                    $back_json = Cache::get(GlobalVar::$LIST_CACHE . $mid);
                } else {
                    $back_json = BiliGetter::getList($mid, 'hot', 1, GlobalVar::$PAGE_SIZE);

                    Cache::add(GlobalVar::$LIST_CACHE . $mid, $back_json, 60);
                }
            } else {
                $back_json = BiliGetter::getList($mid, 'hot', $page, GlobalVar::$PAGE_SIZE);
            }

            $paginator = new Paginator($back_json['list'], $page);
            $paginator->setPath('/list');

            $sorts = CacheSetter::getSort();
            $hot = CacheSetter::getHot();

            return view('pusher.list')->with('sorts', $sorts)->with('list', $back_json['list'])->with("paginator", $paginator)->with('mid', $mid)
                ->with('hots', $hot);

        } catch (Exception $e) {
            abort(404);
        }
    }


    /**
     * 搜索
     * @param $content
     * @return $this
     * @throws Exception
     */
    public function search($content)
    {
        try {

            $content = urldecode($content);

            $page = Input::get('page', 1);

            $back_json = BiliGetter::getSearch($content, $page);


            return view('pusher.search')->with('back', $back_json)->with('search', $content);

        } catch (Exception $e) {
            abort(404);
        }
    }


    /**
     * 搜索分页加载(ajax)
     * @param $content
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws Exception
     */
    public function searchPage($content)
    {
        $content = urldecode($content);

        $page = Input::get('page', 1);

        $back_json = BiliGetter::getSearch($content, $page);

        return response()->json($back_json);
    }


    /**
     * 刷新缓存(定期)
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function pump()
    {
        event(new UpdateEvent());

        return response()->json(true);
    }

}




