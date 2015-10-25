<?php

namespace App\Http\Controllers;

use App\Utils\BiliBiliHelper;
use App\Utils\RequestUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Predis\Client;

class HomeController extends Controller
{

    public function home()
    {
        $redis = new Client();

        $date = $redis->hget('update', 'index');

        $index = $redis->hgetall('index');

        $sorts = array_values(BiliBiliHelper::getSorts());

        foreach ($sorts as $sort) {
            $index[$sort] = json_decode($index[$sort], true);
        }

        return view('index')->with('content', $index)->with('sorts', $sorts)->with('update_time', $date);
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

        //页码非法检测
        if ($page < 1) {
            $page = 1;
        }

        //默认取出redis
        if ($order == 'hot' && $page == 1) {
            $redis = new Client();
            $date = $redis->hget('update', 'sort');

            $sort = $redis->hget('sort', $sorts[$tid]);
            $sort = json_decode($sort, true);
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


    public function view($aid, Request $request)
    {
        try {
            $page = $request->get('page', 1);

            //页码非法检测
            if ($page < 1) {
                $page = 1;
            }

            $request_array = [
                'aid' => $aid,
                'page' => $page,
            ];

            $back = RequestUtil::getUrl(BiliBiliHelper::$SERVICE_URL . '/view?' . http_build_query($request_array));

            return view('play')->with('content', $back['content'])->with('aid', $aid);
        } catch (\Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }


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


    public function search(Request $request)
    {
        try {
            $page = $request->get('page', 1);
            $keyword = $request->get('keyword');

            if (!$keyword) {
                $this->returnError('内容为空');
            }

            //页码非法检测
            if ($page < 1) {
                $page = 1;
            }

            $request_array = [
                'keyword' => $keyword,
                'page' => $page,
                'pagesize' => 8,
            ];

            $back = RequestUtil::getUrl(BiliBiliHelper::$SERVICE_URL . '/search?' . http_build_query($request_array));

            return view('search')->with('back', $back['content'])->with('search', $keyword);

        } catch (\Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }


    public function searchPage($content, Request $request)
    {
        try {
            $page = $request->get('page', 2);

            //页码非法检测
            if ($page < 2) {
                $page = 2;
            }

            $request_array = [
                'keyword' => $content,
                'page' => $page,
                'pagesize' => 8,
            ];

            $back = RequestUtil::getUrl(BiliBiliHelper::$SERVICE_URL . '/search?' . http_build_query($request_array));


            $return_array = [
                'code' => 'success',
                'content' => $back['content'],
            ];

            return response()->json($return_array);
        } catch (\Exception $e) {
            $return_array = [
                'code' => 'error',
                'content' => $e->getMessage(),
            ];
            return response()->json($return_array);
        }
    }

    public function about()
    {
        return view('about');
    }

}