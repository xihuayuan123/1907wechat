<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Tools\Wechat;
use App\Tools\Curl;
use App\Model\Channel;
use App\Model\User;

class ChannelController extends Controller
{

    /*渠道添加*/
    public function create(){
        //展示渠道添加
        return view('channel.create');
    }

    /*执行添加*/
    public function store(Request $request){
        // 接值
        $channel_name = $request->channel_name;
        $channel_status = $request->channel_status;

        // 调用微信生成二维码接口
        $ticket = Wechat::getQrcode( $channel_status );

        // 入库
        $res = Channel::insert([
            'channel_name' => $channel_name,
            'channel_status' => $channel_status,
            'ticket' => $ticket,
        ]);
        if( !empty($res) ){
            echo "<script>alert('添加成功！');location.href='/admin/channel_index'</script>";
        }

    }

    /*渠道展示*/
    public function index(){
        // echo Wechat::getAccessToken();die;
        //展示渠道
        $data = Channel::paginate(2);

        return view('channel.index',['data' => $data]);
    }

    /*统计图表*/
    public function charts(){

        // 查询用户表
        $data = Channel::get()->toArray();

        // 循环数据
        $xStr = "";
        $yStr = "";
        foreach( $data as $v ){
            $xStr .= '"'.$v['channel_name'].'",' ;
            $yStr .= $v['num'].',';
        }
        $xStr = rtrim($xStr,',');
        $yStr = rtrim($yStr,',');

        return view('channel.charts',['xStr' => $xStr,'yStr' => $yStr]);

    }

}
