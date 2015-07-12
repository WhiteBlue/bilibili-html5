<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


$app->get('/', 'HomeController@index');


//关于Pusher
$app->get('/about', 'HomeController@about');

//定时任务
$app->get('/pump', ['middleware' => 'baseLogin', 'uses' => 'HomeController@pump']);


$app->get('/catch', 'HomeController@catchUrl');


/*
|--------------------------------------------------------------------------
| 用户个人中心
|--------------------------------------------------------------------------
*/

$app->group(['prefix' => 'me', 'middleware' => 'login'], function ($app) {
    $app->get('/', 'App\Http\Controllers\MeController@index');


    $app->get('/auth/logout', 'App\Http\Controllers\AuthController@logout');
});

/*
|--------------------------------------------------------------------------
| 认证相关
|--------------------------------------------------------------------------
*/
$app->group(['prefix' => 'auth', '/middleware' => 'hasLogin'], function ($app) {
    $app->get('/', 'App\Http\Controllers\AuthController@getLogin');

    $app->get('register', 'App\Http\Controllers\AuthController@getRegister');

    $app->get('login', 'App\Http\Controllers\AuthController@getLogin');

    $app->post('postLogin', 'App\Http\Controllers\AuthController@postLogin');

    $app->post('postRegister', 'App\Http\Controllers\AuthController@postRegister');
});

