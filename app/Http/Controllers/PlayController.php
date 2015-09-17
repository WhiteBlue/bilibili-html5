<?php

namespace App\Http\Controllers;

use App\Utils\BiliUtil;
use Exception;

/**
 * Created by PhpStorm.
 * User: WhiteBlue
 * Date: 15/9/17
 * Time: 下午8:05
 */
class PlayController extends Controller
{

    /**
     * 低清视频源
     *
     * @param $aid
     * @param $page
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function playNormal($aid, $page)
    {
        try {
            $bili_util = new BiliUtil();

            $result = $bili_util->getNormalVideo($aid, $page);

            $return_array = [
                'code' => 'success',
                'content' => $result,
            ];

            return response()->json($return_array);
        } catch (Exception $e) {
            $return_array = [
                'code' => 'error',
                'message' => $e->getMessage(),
            ];

            return response()->json($return_array);
        }
    }


    /**
     * 取得HD片源
     *
     * @param $cid
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function playHD($cid)
    {
        try {
            $bili_util = new BiliUtil();

            $result = $bili_util->getHDVideo($cid);

            $return_array = [
                'code' => 'success',
                'content' => $result['durl'][0],
            ];

            return response()->json($return_array);
        } catch (Exception $e) {
            $return_array = [
                'code' => 'error',
                'message' => $e->getMessage(),
            ];

            return response()->json($return_array);
        }
    }

}