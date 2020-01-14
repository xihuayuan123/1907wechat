<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Tools\Wechat;
use App\Model\Media;
use App\Tools\Curl;

class MediaController extends Controller
{

    //素材添加
    public function create(){

        //微信接口
        // $access_token = Wechat::getAccessToken();
        // echo $access_token;die;
        return view('media.create');

    }

    //执行添加
    public function store( Request $request ){

        // 接收表单中name属性值
        $data = $request->input();

        //文件上传
        $file = $request->file;
        $ext = $file->getClientOriginalExtension(); //得到文件后缀名
        $filename = md5(uniqid()).".".$ext;
        if ( !$request->hasFile('file') ) {
            echo "没有！";die;
        }
        $filePath = $file->storeAs('images',$filename);

        // 调用微信上传素材接口 把图片=> 微信服务器
        $access_token = Wechat::getAccessToken();
        $type = $data['media_format'];
        $url = "https://api.weixin.qq.com/cgi-bin/media/upload?access_token=".$access_token."&type=".$type;
        // curl发送文件需要先通过CURLFile类处理
        $filePathObj = new \CURLFile( public_path()."/".$filePath );
        $postData = ['media' => $filePathObj];
        $res = Curl::post( $url,$postData );
        $res = json_decode($res,true);
        $media_id = $res['media_id']; //微信返回的素材id
        //入库
        $result = Media::create([
            'media_name' => $data['media_name'],
            'media_format' => $data['media_format'],
            'media_type' => $data['media_type'],
            'media_url' => $filePath,
            'wechat_media_id' => $media_id,
            'add_time' => time(),
        ]);
        if( !empty($result) ){
            echo "<script>alert('添加成功！');location.href='/admin/media_index'</script>";
        }

    }

    //素材展示
    public function index(){

        $data = Media::paginate(2);

        return view('media.index',['data' => $data]);

    }

}
