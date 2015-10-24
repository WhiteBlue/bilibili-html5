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

$app->get('/view/{aid}', 'HomeController@view');

$app->get('/video/{quality}', 'HomeController@video');

$app->get('/search', 'HomeController@search');

$app->get('/searchPage/{content}', 'HomeController@searchPage');

$app->get('/about', 'HomeController@about');
