<?php

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your module. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('acceso/roles', function(Request $request) {
    $endpoint = "//homologacion.mavaite.com/poga-api-rest/api/v1/acceso/roles";
    $client = new Client();
    $token = $request->header('Authorization');
    $response = $client->request('GET', $endpoint, [
        'headers' => [
            'x-li-format' => 'json',
            'Authorization' => $token,
        ]
    ]);

    return json_decode($response->getBody()->getContents(), true);
});

Route::post('login', 'Auth\LoginController@login');
Route::post('register', 'Auth\RegisterController@register');
