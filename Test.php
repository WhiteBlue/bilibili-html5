<?php
/**
 * Created by PhpStorm.
 * User: WhiteBlue
 * Date: 15/10/21
 * Time: 上午12:43
 */
require 'vendor/autoload.php';

use App\Utils\RequestUtil;

$util = new RequestUtil();

try {

    $back = $util->getUrl('http://127.0.0.1:4567/view');
    echo $back;

} catch (Exception $e) {
    echo $e->getMessage();
}