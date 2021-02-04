<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::resource('demo', "DemoController");
Route::get('/db/', 'DbController@index');
Route::get('/db/all', 'DbController@all')->name('db.all');
Route::get('/db/one', 'DbController@one')->name('db.one');
Route::get('/db/kill', 'DbController@dbKill')->name('db.kill');

Route::get('redis', 'RedisLocalController@index');
Route::get('redis/normal-kill', 'RedisLocalController@normalKill');
Route::get('redis/le-guan-kill', 'RedisLocalController@leGuanKill');


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
    Route::name("admin.")->namespace("Admin")->group(function () {
        Route::get('redis', "RedisController@index");
        Route::get('redis/all', "RedisController@all")->name("redis.all");
    });
});

Route::get('proto', 'ProtoBufController@proto')->name('proto');
Route::get('json', 'ProtoBufController@json')->name('json');
