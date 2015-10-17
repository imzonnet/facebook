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


Route::get('/facebook', 'FacebookController@index');
Route::get('/fb/token', ['as' => 'fb.token', 'uses' => 'FacebookController@checkToken']);
Route::get('/fb/group', ['as' => 'fb.group', 'uses' => 'FacebookController@pushGroups']);
Route::post('/fb/group', ['as' => 'fb.group', 'uses' => 'FacebookController@postGroups']);
