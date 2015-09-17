<?php

namespace App\Http\Controllers;

use App\Dao\DataAccess;
use App\Events\UpdateEvent;
use App\Utils\BiliUtil;
use App\Utils\CacheSetter;
use App\Utils\GlobalVar;
use Exception;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use Laravel\Lumen\Routing\Controller;

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
     *
     * @return $this
     */
    public function index()
    {
        $index_list = Cache::get(GlobalVar::$INDEX_LIST_CACHE);

        $time = Cache::get(GlobalVar::$UPDATE_TIME);

        return view('pusher.index')->with('list', $index_list)->with('time', $time);
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

            $page = Request::input('page', 1);

            //数据库是否已有记录
            $result = DataAccess::getSave($aid, $page);
            if ($result == null) {
                $bili_util = new BiliUtil();

                $result = $bili_util->getInfo($aid, $page);

                $result = DataAccess::saveNew($result, $aid);
            }

            return view('pusher.play')->with('info', $result)->with('aid', $aid)->with('page', $page);

        } catch (Exception $e) {
            return view('pusher.error')->with('error_content', '视频没有找到的说..');
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
            $back_json = Cache::get(GlobalVar::$NEW_LIST_CACHE);

            date_default_timezone_set('PRC');

            $weekday = date('w');

            $time = Cache::get(GlobalVar::$UPDATE_TIME);

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
            $tid = Input::get('tid', 0);
            $page = Input::get('page', 1);
            $order = Input::get('order', 'hot');

            $bili_util = new BiliUtil();

            if ($page == 1) {
                $cache_name = GlobalVar::$LIST_CACHE . $tid;
                if (!Cache::has($cache_name)) {
                    $back_json = $bili_util->getPageList($tid, $order, 1, GlobalVar::$PAGE_SIZE);

                    Cache::add($cache_name, $back_json, 60 * 60 * 2);
                } else {
                    $back_json = Cache::get($cache_name);
                }
            } else {
                $back_json = $bili_util->getPageList($tid, $order, $page, GlobalVar::$PAGE_SIZE);
            }

            $paginator = new Paginator($back_json['list'], $page);
            $paginator->setPath('/list');

            $sorts = CacheSetter::getSort();
            $hot = CacheSetter::getHot();


            return view('pusher.list')->with('sorts', $sorts)->with('list', $back_json['list'])->with("paginator", $paginator)->with('tid', $tid)
                ->with('hots', $hot);

        } catch (Exception $e) {
            return view('pusher.error')->with('error_content', $e->getMessage());
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
            $key_word = urldecode($content);

            $page = Input::get('page', 1);

            $bili_util = new BiliUtil();

            $back_json = $bili_util->getSearch($key_word, $page);

            return view('pusher.search')->with('back', $back_json)->with('search', $content);

        } catch (Exception $e) {
            return view('pusher.error')->with('error_content', $e->getMessage());
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
        try {
            $key_word = urldecode($content);

            $page = Input::get('page', 1);

            $bili_util = new BiliUtil();

            $back_json = $bili_util->getSearch($key_word, $page);

            $return_array = [
                'code' => 'success',
                'content' => $back_json,
            ];

            return response()->json($return_array);
        } catch (Exception $e) {
            $return_array = [
                'code' => 'error',
                'msg' => $e->getMessage(),
            ];

            return response()->json($return_array);
        }
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


    public function test()
    {
        $bili_util = new BiliUtil();
        $back = $bili_util->getHDVideo('4553207');
        dd($back);
    }

}




