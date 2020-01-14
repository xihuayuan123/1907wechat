<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tools\Wechat;
use App\Tools\Curl;
use App\Model\Media;
use App\Model\News;
use App\Model\Channel;
use App\Model\User;

class WechatController extends Controller
{

    private  $student = [
        '张三',
        '李四',
        '王五',
        '哈哈'
    ];

     /*测试*/
    public function index()
    {

        /*接入*/
        /*
         * 提交按钮 微信服务器GET请求=》 echostr
         * 原样输出echostr即可
        */
        $echostr = request()->input('echostr');
        if( !empty($echostr) ){
            echo $echostr;
        }

        /**接入完成之后，微信公众号内用户任何操作 微信服务器=》POST形式XML格式 发送到配置的url上*/
	    $xml = file_get_contents("php://input"); //接收原始的xml或json数据流

        // 写入文件里
        file_put_contents("log.txt","\n\n".$xml."\n",FILE_APPEND);

         /*处理xml=>对象*/
        $xmlObj = simplexml_load_string($xml);

        /*如果是关注*/
        if( $xmlObj->MsgType == 'event' && $xmlObj->Event == 'subscribe' ){
            /*回复消息*/
            /*关注时 获取用户基本信息
            *获取access_token（微信接口调用凭证）
            */
            $data = Wechat::getUserInfoByOpenId( $xmlObj->FromUserName );

            // 得到渠道的标识
            $channel_status = $data['qr_scene_str'];

            // 根据渠道标识 关注人数递增
            Channel::where(['channel_status'=>$channel_status])->increment('num');
            //$result['channel_status']=$channel_status;

            //判断用户基本信息表 有没有数据(通过openid查询表)
            $where = [
                ['openid','=',$data['openid']]
            ];
            $res = User::where($where)->first();

            // 如果有数据 修改状态  修改渠道号  如果没有数据 添加
            if( $res ){
                $is_status = User::where(['openid' => $xmlObj->FromUserName])->update(['is_status'=>1]); // 状态
                $channel_status = User::where(['openid' => $xmlObj->FromUserName])->update(['channel_status'=>$data['qr_scene_str']]); // 渠道号
            }elseif( !$res ){
                $data = Wechat::getUserInfoByOpenId( $xmlObj->FromUserName ); //获取用户信息
                //存入用户基本信息
                $UserData = User::create([
                    'openid' => $data['openid'],
                    'nickname' => $data['nickname'],
                    'city' => $data['city'],
                    'channel_status' => $channel_status,
                ]);
            }

            $nickname = $data['nickname'];

            if( $data['sex'] == 1 ){
                $sex = '先生';
            }elseif($data['sex']==2){
                $sex = '女士';
            }
            Wechat::reponseText($xmlObj,'欢迎'.$nickname.$sex.'关注!');

        }

        /*如果用户是取消关注*/
        if( $xmlObj->MsgType == 'event' && $xmlObj->Event == 'unsubscribe' ){

            // 查询用户信息表 通过openid得到渠道标识
            $userInfo = Wechat::getUserInfoByOpenId( $xmlObj->FromUserName );

            $openid = $userInfo['openid'];

            $where = [
                ['openid','=',$openid]
            ];
            $channel_status = User::where($where)->first(['channel_status'])->toArray();

            // 渠道表统计人数-1 根据渠道标识  取注人数递减
            Channel::where(['channel_status'=>$channel_status])->decrement('num');

            // 用户基本信息表中 修改状态
            $result = User::where(['openid' => $xmlObj->FromUserName])->update(['is_status'=>2]);

        }

         /*如果是用户发送过来的文本消息*/
        if( $xmlObj->MsgType == 'text' ){
             /*得到用户发送内容*/
            $content = trim($xmlObj->Content);

            if( $content == '1' ){
                /*回复文本消息*/
                $msg = implode(',',$this->student);
                Wechat::reponseText($xmlObj,$msg);
            }else if( $content == '2' ){
                /*随机回复文本消息*/
                shuffle($this->student);
                $msg = $this->student[0];
                Wechat::reponseText($xmlObj,$msg);
            }else if( mb_strpos($content,"天气")!==false ){

                // 回复天气
                $city = rtrim($content,"天气");

                if(empty($city)){
                    $city = '北京';
                }

                // 调用天气接口 获取数据信息
                $url = "http://api.k780.com/?app=weather.future&weaid=".$city."&&appkey=47868&sign=11f70c80aed15863b86528100ec55b87&format=json";

                $data = file_get_contents($url);
                $data = json_decode($data,true);

                $msg = "";

                foreach ($data['result'] as $key => $value) {
                    $msg .= $value['days']." ".$value['week']." ".$value['citynm']." ".$value['temperature']."\n";
                }
                Wechat::reponseText($xmlObj,$msg);

            }else if( $content == '最新新闻' ){
                //回复一条最新新闻  数据库查询  倒叙
                // select * from news order by new_id desc limit 1;
                $res = News::Orderby('new_id','desc')->limit(1)->first();
                $msg = $res['new_content'];
                Wechat::reponseText($xmlObj,$msg);
            }else if( mb_strpos($content,"新闻+")!==false ){
                $keyWords = ltrim($content,"新闻+");
                //数据库中查询数据
                $res = News::Orderby('new_id','desc')->get();
                $msg = '';
                foreach($res as $v){
                    $msg .= $v['new_content'];
                }
                Wechat::reponseText($xmlObj,$msg);

            }

        }

        /*如果是用户发送过来的图片消息*/
        if( $xmlObj->MsgType=='image'){
            //斗图功能 （随机从数据库中回复一张图片）
            $data=Media::get()->toArray();
            foreach($data as $k=>$v){
                if($data[$k]["media_format"]=='image'){
                    $media_id=array_column($data,'wechat_media_id');
                    shuffle($media_id);
                    $media_id=$media_id[0];
                }
            }

            echo "
                <xml>
                    <ToUserName><![CDATA[".$xmlObj->FromUserName."]]></ToUserName>
                    <FromUserName><![CDATA[".$xmlObj->ToUserName."]]></FromUserName>
                    <CreateTime>".time()."</CreateTime>
                    <MsgType><![CDATA[image]]></MsgType>
                    <Image>
                    <MediaId><![CDATA[".$media_id."]]></MediaId>
                    </Image>
                </xml>";die;
        }

    }

    /*创建菜单*/
    public function menu()
    {

        // 菜单接口地址
        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".Wechat::getAccessToken();

        // 自定义菜单接口多种类型按钮
        $menu = [
            "button"    => [
                [
                    "type"  => "view",
                    "name"  => "今日歌曲",
                    "url"   => "http://www.kugou.com/"
                ],
                [
                    "name"  => "合集",
                    "sub_button"    => [
                        [
                            "type"  => "scancode_push",
                            "name"  => "扫一扫",
                            "key"   => "scan111"
                        ],
                        [
                            "type"  =>  "pic_photo_or_album",
                            "name"  =>  "拍照或者相册发图",
                            "key"   =>   "photo",
                            "sub_button"  => [ ]
                        ]
                    ]
                ],
                [
                    "name"  => "更多",
                    "sub_button"    => [
                        [
                            "type"  => "view",
                            "name"  => "京东购物",
                            "url"   => "http://www.jd.com/"
                        ],
                        [
                            "name"  =>  "发送位置",
                            "type"  => "location_select",
                            "key"   => "position"
                        ],
                        [
                            "type"  => "click",
                            "name"  => "明日运势",
                            "key"   => "Luck"
                        ]
                    ]
                ],
            ]
        ];
        dd($menu);
        /*
         * 用PHP的json_encode来处理中文的时候, 中文都会被编码, 变成不可读的,
         * 使用JSON_UNESCAPED_UNICODE,就让Json不要编码Unicode.
         * */
        $menu=json_encode($menu,JSON_UNESCAPED_UNICODE);
        $output=Curl::post($url,$menu);
        $res = json_decode($output,true);

    }

    /*下载图片*/
    protected function getDownImg($media_id)
    {

        $access_token = Wechat::getAccessToken();

        // 获取下载图片接口
        $url = ' https://api.weixin.qq.com/cgi-bin/media/get?access_token='.$access_token.'&media_id='.$media_id;

        // 请求获取素材接口
        $img = file_get_contents($url);
        dd($img);

    }

}

