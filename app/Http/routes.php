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

/* Frontend */

$app->get('/', function() use ($app) {
    return view('pages.home');
});

$app->get('/api', function() use ($app) {
    return view('pages.api');
});

$app->get('/monitor', function() use ($app) {
    return view('pages.monitor');
});

/* API */

$app->get('/api/v1/check', 'App\Http\Controllers\ApiController@check');
