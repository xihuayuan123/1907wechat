<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{

    //首页展示
    public function index(){
        return view('admin.index');
    }

    // 展示天气
    public function getWeather(){
        return view('admin.weather');
    }

}
