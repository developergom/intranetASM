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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', 'Test@index');

/*Route::get('/login', 'AuthController@login');
Route::post('/authenticate', 'AuthController@authenticate');
Route::get('/dashboard', ['as' => 'dashboard', 'uses' => 'Test@index']);*/

Route::auth();

Route::get('/home', 'HomeController@index');
