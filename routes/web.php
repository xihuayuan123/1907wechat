<?php

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

Route::any('/wechat/index','WechatController@index'); //测试微信服务器
Route::any('/wechat/menu','WechatController@menu'); //测试生成菜单

//微信
Route::prefix('/admin')->group(function () {

    Route::any('/','Admin\IndexController@index'); //首页

    Route::any('/weather','Admin\IndexController@getWeather'); //首页天气

    Route::any('/login','Admin\LoginController@login'); //登录
    Route::any('/login/logindo','Admin\LoginController@loginDo');  //执行登陆

    Route::any('/media_create','Admin\MediaController@create'); //素材管理--添加
    Route::any('/media_store','Admin\MediaController@store'); //素材管理--执行添加
    Route::any('/media_index','Admin\MediaController@index'); //素材管理--展示

    Route::any('/channel_create','Admin\ChannelController@create'); //渠道管理--添加
    Route::any('/channel_store','Admin\ChannelController@store'); //渠道管理--执行添加
    Route::any('/channel_index','Admin\ChannelController@index'); //渠道管理--展示
    Route::any('/channel_charts','Admin\ChannelController@charts'); //渠道管理--统计图表


});

//新闻
Route::prefix('/news')->group(function () {

    Route::any('/create','News\NewsController@create'); //新闻添加
    Route::any('/store','News\NewsController@store'); //执行添加
    Route::any('/index','News\NewsController@index'); //新闻展示
    Route::any('/delete/{id}','News\NewsController@delete'); //新闻删除
    Route::any('/edit/{id}','News\NewsController@edit'); //新闻编辑
    Route::any('/update/{id}','News\NewsController@update'); //执行编辑

});
