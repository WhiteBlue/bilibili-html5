<?php

namespace App\Http\Controllers;

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

    public function test()
    {
        $sort_list = [];

        foreach (BiliBiliHelper::getNicoSorts() as $key => $value) {
            $back = RequestUtil::normalGetUrl('http://www.nicovideo.jp/ranking/fav/hourly/' . $key . '?rss=2.0&lang=ja-jp');

            $xmlDoc = new DOMDocument();
            $xmlDoc->loadXML($back);

            $element = $xmlDoc->documentElement;
            $chanel = $element->getElementsByTagName('channel')->item(0);

            $video_array = [];

            foreach ($chanel->getElementsByTagName('item') as $item) {
                $inner = [];
                $inner['title'] = explode('：', $item->getElementsByTagName('title')[0]->nodeValue)[1];
                $inner['id'] = explode('watch/', $item->getElementsByTagName('link')[0]->nodeValue)[1];
                array_push($video_array, $inner);
            }
            $sort_list[$key] = $video_array;
        }

        Cache::forever('nico_cache', $sort_list);

        dd('ok');

    }

}