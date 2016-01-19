<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', 'HomeController@home');

$app->get('/sort/{tid}', 'HomeController@sort');

//$app->get('/sortnico/{sort}', 'HomeController@nicoSort');

$app->get('/view/{aid}', 'HomeController@view');

//$app->get('/viewnico/{id}', 'HomeController@viewNico');

$app->get('/search', 'HomeController@search');

$app->get('/about', 'HomeController@about');

$app->get('/sp/{spid}', 'HomeController@sp');

$app->get('/spvideo/{spid}', 'HomeController@get_sp_video');

$app->get('/bangumi', 'HomeController@bangumi');


