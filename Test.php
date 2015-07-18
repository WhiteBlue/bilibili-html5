<?php

/**
 * Created by PhpStorm.
 * User: WhiteBlue
 * Date: 15/7/10
 * Time: 上午10:55
 */


function get_sign($params, $app_key, $secret_key)
{
    $_data = array();
    $params['appkey'] = $app_key;

    ksort($params);
    reset($params);

    foreach ($params as $k => $v) {
        $_data[] = $k . '=' . urlencode($v);
    }
    $_sign = implode('&', $_data);
    return array(
        'sign' => strtolower(md5($_sign . $secret_key)),
        'params' => $_sign,
    );
}


$back = get_sign(['keyword' => '233'], '4ebafd7c4951b366', '8cb98205e9b2ad3669aad0fce12a4c13');

echo $back['sign'] . '||' . $back['params'];