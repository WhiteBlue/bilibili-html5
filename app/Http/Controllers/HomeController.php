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

    //首页
    public function home()
    {
        $index_list = Cache::get('index_cache');
        $update_time = Cache::get('refresh_time');
        $sorts = BiliBiliHelper::$sorts;
        return view('index')->with('list', $index_list)->with('update_time', $update_time)->with('sorts', $sorts);
    }

    //分类
    public function sort($tid, Request $request)
    {
        $sorts = BiliBiliHelper::$sorts;
        //分类非法检测
        if (!array_has($sorts, $tid)) {
            return $this->returnError('分类不存在');
        }
        $order = $request->get('order', 'hot');
        $page = $request->get('page', 1);
        //页码非法检测
        $page = ($page < 1) ? 1 : $page;

        if ($order == 'hot' && $page == 1) {
            $sort_list = Cache::get('sort_cache');
            $date = Cache::get('refresh_time');
            $sort = $sort_list[strval($tid)];
        } else {
            try {
                $request_array = [
                    'order' => $order,
                    'page' => $page,
                    'count' => 16
                ];

                $date = date('H:i:s');
                $back = RequestUtil::getUrl(BiliBiliHelper::$SERVICE_URL . "/sort/$tid?" . http_build_query($request_array));

                if ($back['code'] = 200) {
                    $sort = $back['content'];
                } else {
                    throw new Exception();
                }
            } catch (\Exception $e) {
                return $this->returnError('服务器君忙，待会再试吧...');
            }
        }

        $list = $sort['list'];
        if (array_has($list, 'num')) {
            unset($list['num']);
        }
        $sort['list'] = $list;

        return view('sort')->with('content', $sort)->with('tid', $tid)->with('page', $page)->with('order',
            $order)->with('date', $date);
    }


    //观看
    public function view($aid, Request $request)
    {
        try {
            $back = RequestUtil::getUrl(BiliBiliHelper::$SERVICE_URL . "/view/$aid");

            if ($back['code'] != 200) {
                throw new Exception('视频未找到...');
            }

            $content = $back['content'];

            $count = Video::where('aid', '=', $aid)->count();
            if ($count == 0) {
                $video = [
                    'aid' => intval($aid),
                    'title' => $content['title'],
                    'author' => $content['author'],
                    'description' => $content['description'],
                    'created' => $content['created'],
                    'created_at' => $content['created_at'],
                    'face' => $content['face'],
                    'typename' => $content['typename'],
                    'pages' => $content['pages'],
                    'list' => serialize($content['list'])
                ];
                try {
                    Video::create($video);
                } catch (Exception $ignore) {
                }
            }
            $content['aid'] = $aid;

            return view('play')->with('video', $content);
        } catch (\Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }


    //搜索
    public function search(Request $request)
    {
        try {
            $page = $request->get('page', 1);
            $keyword = $request->get('keyword');
            $order = $request->get('order', 'totalrank');
            $type = $request->get('type', 'video');

            if (!in_array($type, BiliBiliHelper::$search_types)) {
                return $this->returnError('分类不正确');
            }
            if (!$keyword) {
                return $this->returnError('内容为空');
            }

            $request_array = [
                'content' => $keyword,
                'page' => $page,
                'count' => 20,
                'type' => $type,
                'order' => $order
            ];

            $back = RequestUtil::postUrl(BiliBiliHelper::$SERVICE_URL . '/search', $request_array);

            if ($back['code'] == 200) {
                $back = $back['content'];
            } else {
                throw new Exception('API返回异常');
            }

            $render_data = [
                'keyword' => $keyword,
                'content' => $back,
                'page' => $page,
                'type' => $type
            ];

            return view('search', $render_data);
        } catch (\Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }


    //关于
    public function about()
    {
        return view('about');
    }


    public function sp($spid)
    {
        try {
            $back = RequestUtil::getUrl(BiliBiliHelper::$SERVICE_URL . "/spinfo/$spid");

            if ($back['code'] != 200) {
                return $this->returnError("404...专题不存在");
            }

            return view('sp')->with('content', $back['content']);
        } catch (\Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }


    //取得专题视频
    public function get_sp_video($spid, Request $request)
    {
        try {
            $type = $request->get('type', 0);

            $back = RequestUtil::getUrl(BiliBiliHelper::$SERVICE_URL . "/spvideos/$spid?bangumi=$type");

            if ($back['code'] != 200) {
                throw new Exception;
            }

            return response()->json([
                'code' => 'success',
                'content' => $back['content']
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    //新番页面
    public function bangumi()
    {
        $bangumi_list = Cache::get('bangumi_cache');

        $today = date('w');

        return view('bangumi')->with('content', $bangumi_list)->with('today', $today);
    }

    //nico视频观看
    public function viewNico($id)
    {
        $request_aray = [
            '__format' => 'json',
            'v' => $id,
        ];
        try {
            $back = RequestUtil::normalGetUrl('http://api.ce.nicovideo.jp/nicoapi/v1/video.info?' . http_build_query($request_aray));
            $back = json_decode($back, true);
            $content = $back['nicovideo_video_response'];
            if ($content['@status'] != 'ok') {
                throw new Exception('Back error...');
            }
            return view('play_nico')->with('content', $content['video']);
        } catch (\Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }

    public function nicoSort($sort, Request $request)
    {
        $sorts = BiliBiliHelper::getNicoSorts();
        //分类非法检测
        if (!array_has($sorts, $sort)) {
            return $this->returnError('分类不存在');
        }

        $page = $request->get('page', 1);

        //页码非法检测
        $page = ($page < 1) ? 1 : $page;
        $page = ($page > 2) ? 2 : $page;

        $content = Cache::get('nico_cache');
        $date = Cache::get('refresh_time');

        $lists = array_chunk($content[$sort], 50);

        return view('sort_nico')->with('list', $lists[$page - 1])->with('page', $page)->with('sort',
            $sort)->with('date', $date)->with('tag_name', $sorts[$sort]);
    }
}