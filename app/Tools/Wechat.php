<?php

namespace App\Tools;
use Illuminate\Support\Facades\Cache;
use App\Tools\Curl;

//微信核心类
class Wechat
{

    const appId = "wxe1575b769685a261";
    const appSerect = "c0c0abac6b40e2047f343d5ab3774efd";


    /**
     *回复文本消息
    */
    public static function reponseText( $xmlObj,$msg ){

        echo "<xml>
	  	<ToUserName><![CDATA[".$xmlObj->FromUserName."]]></ToUserName>
	  	<FromUserName><![CDATA[".$xmlObj->ToUserName."]]></FromUserName>
	  	<CreateTime>".time()."</CreateTime>
	 	<MsgType><![CDATA[text]]></MsgType>
	  	<Content><![CDATA[".$msg."]]></Content>
	    </xml>";die;

    }

     /*
     * 获取微信接口凭证
    */
     public static function getAccessToken(){

         //先判断缓存是否有数据
         $access_token = Cache::get('access_token');
         //有数据返回
         if( empty($access_token) ){
             // 获取access_token(微信接口调用凭证)
             $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".Self::appId."&secret=".Self::appSerect;
             $data = file_get_contents($url);
             $data = json_decode($data,true);
             $access_token = $data['access_token'];
             Cache::put('access_token',$access_token,7200);
         }
         // 没有数据在进去调微信接口获取=》存入缓存
         return $access_token;
     }

     /*
     *获取用户信息
     */
     public static function getUserInfoByOpenId($openid){
         $access_token = Self::getAccessToken();
         $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";

         $data = file_get_contents($url);
         $data = json_decode($data,true);
         return $data;
     }

     /*
      * 获取微信二维码接口
     */
     public static function getQrcode( $channel_status ){
         // 调用微信生成二维码接口
         $url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.Wechat::getAccessToken();
         //参数
         $postData = [
             'expire_seconds' => 2592000,
             'action_name' => "QR_STR_SCENE",
             'action_info' => [
                 'scene' =>[
                     'scene_str' => $channel_status
                 ]
             ]
         ];
         $postData = json_encode($postData); //转json格式
         //请求方式
         $res = Curl::post($url,$postData);
         $res = json_decode($res,true); //转数组
         $ticket = $res['ticket'];
         return $ticket;
     }

}
