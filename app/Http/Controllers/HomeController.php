<?php

namespace App\Http\Controllers;

use App\Utils\BiliBiliHelper;
use App\Utils\RequestUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Predis\Client;

class HomeController extends Controller
{

    //首页
    public function home()
    {
        $index_list = Cache::get('index_cache');
        $update_time = Cache::get('refresh_time');
        $sorts = BiliBiliHelper::getSorts();
        return view('index')->with('list', $index_list)->with('update_time', $update_time)->with('sorts', $sorts);
    }

    //分类
    public function sort($tid, Request $request)
    {
        $sorts = BiliBiliHelper::getSorts();

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
                    'tid' => $tid,
                    'order' => $order,
                    'page' => $page,
                    'pagesize' => 20
                ];

                $date = date('H:i:s');
                $back = RequestUtil::getUrl(BiliBiliHelper::$SERVICE_URL . '/sort?' . http_build_query($request_array));

                $sort = $back['content'];
            } catch (\Exception $e) {
                return $this->returnError('服务器君忙，待会再试吧...');
            }
        }

        return view('sort')->with('content', $sort)->with('tid', $tid)->with('page', $page)->with('date', $date);
    }


    //观看
    public function view($aid, Request $request)
    {
        try {
            $page = $request->get('page', 1);

            //页码非法检测
            $page = ($page < 1) ? 1 : $page;

            $request_array = [
                'aid' => $aid,
                'page' => $page,
            ];

            $back = RequestUtil::getUrl(BiliBiliHelper::$SERVICE_URL . '/view?' . http_build_query($request_array));

            return view('play')->with('content', $back['content'])->with('aid', $aid)->with('page', $page);
        } catch (\Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }

    //获取地址
    public function video($quality, Request $request)
    {
        try {
            $aid = $request->get('aid');
            $cid = $request->get('cid');

            $request_array = [
                'aid' => $aid,
                'cid' => $cid,
                'quality' => $quality
            ];

            if ($quality == '0' || $quality == '3') {
                $back = RequestUtil::getUrl(BiliBiliHelper::$SERVICE_URL . '/videoMobile?' . http_build_query($request_array));
                $result = $back['content'];

                $return_array = [
                    'code' => 'success',
                    'content' => $result['durl'][0]['url'],
                ];
            } else {
                $back = RequestUtil::getUrl(BiliBiliHelper::$SERVICE_URL . '/videoHtml?' . http_build_query($request_array));
                $result = $back['content'];

                $return_array = [
                    'code' => 'success',
                    'content' => $result['src']
                ];
            }

            return response()->json($return_array);
        } catch (\Exception $e) {
            $return_array = [
                'code' => 'error',
                'content' => $e->getMessage()
            ];
            return response()->json($return_array);
        }
    }


    //搜索
    public function search(Request $request)
    {
        try {
            $page = $request->get('page', 1);
            $keyword = $request->get('keyword');

            if (!$keyword) {
                $this->returnError('内容为空');
            }

            $page = ($page < 1) ? 1 : $page;

            $request_array = [
                'keyword' => $keyword,
                'page' => $page,
                'pagesize' => 16,
            ];

            $back = RequestUtil::getUrl(BiliBiliHelper::$SERVICE_URL . '/search?' . http_build_query($request_array));

            return view('search')->with('back', $back['content'])->with('page', $page)->with('search', $keyword);
        } catch (\Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }


    //关于
    public function about()
    {
        return view('about');
    }


    public function sp($name)
    {
        try {
            $back = RequestUtil::getUrl(BiliBiliHelper::$SERVICE_URL . '/sp?name=' . $name);

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

            $request_array = [
                'spid' => $spid,
                'type' => $type
            ];

            $back = RequestUtil::getUrl(BiliBiliHelper::$SERVICE_URL . '/spvideo?' . http_build_query($request_array));

            return response()->json($back);
        } catch (\Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }

    //新番页面
    public function bangumi()
    {
        $bangumi_list = Cache::get('bangumi_cache');

        $today = date('w');

        return view('bangumi')->with('content', $bangumi_list)->with('today', $today);
    }

    public function test()
    {
        try {
            $sort_list = [];
            foreach (BiliBiliHelper::getSorts() as $key => $value) {
                $request_array = [
                    'tid' => $key,
                    'order' => 'hot',
                    'page' => '1',
                    'pagesize' => '20'
                ];
                $back = RequestUtil::getUrl(BiliBiliHelper::$SERVICE_URL . '/sort?' . http_build_query($request_array));
                $sort_list[$key] = $back['content'];
            }

            $index = RequestUtil::getUrl(BiliBiliHelper::$SERVICE_URL . '/index');
            $refresh_time = date('H:i:s');

            $bangumi = RequestUtil::getUrl(BiliBiliHelper::$SERVICE_URL . '/bangumi?type=2');
            $bangumi_result = [];

            for ($i = 0; $i < 7; $i++) {
                $day_bangumi = [];
                $bangumi_result[$i] = $day_bangumi;
            }

            foreach ($bangumi['content']['list'] as $animation) {
                if (isset($animation['cover'])) {
                    array_push($bangumi_result[$animation['weekday']], $animation);
                }
            }

            Cache::forever('index_cache', $index['content']);
            Cache::forever('sort_cache', $sort_list);
            Cache::forever('refresh_time', $refresh_time);
            Cache::forever('bangumi_cache', $bangumi_result);

            dd('ok');
        } catch (\Exception $e) {
            dd($e);
        }
    }

}