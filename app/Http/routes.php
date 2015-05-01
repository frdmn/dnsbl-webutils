<?php
use Illuminate\Support\Facades\Request;

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

/* Configuration file */

$app->configure('config');

$app->settings = [
  'title' => config('config.settings.title')
];

/* Frontend */

$app->get('/', function() use ($app) {
    return view('pages.home', $app->settings);
});

$app->get('/api', function() use ($app) {
    return view('pages.api', $app->settings);
});

$app->get('/monitor', function() use ($app) {
    return view('pages.monitor', $app->settings);
});

/* API */

// Check a hostname against all DNSBLs
$app->get('/api/v1/check/{hostname}', 'App\Http\Controllers\ApiController@check');

// Probe a specific hostname against a DNSBL
$app->get('/api/v1/probe/{hostname}/{dnsbl}', 'App\Http\Controllers\ApiController@probe');
