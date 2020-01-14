<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Login;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    //展示登录
    public function login(){
        return view('login.login');
    }

    // 执行登录
    public function loginDo(){

        // 接收表单值
        $data=request()->except('_token');

        // 根据查询到的信息查询一条数据
        $info=Login::where('account',$data['account'])->first();

        if($info){
            $error_num=$info['error_num'];
            $last_error_time=$info['last_error_time'];
            $time=time();
            if($info['pwd']==$data['pwd']){
                //密码正确
                if($error_num>=3&&$last_error_time<3600){
                    $min=60-ceil(($time-$last_error_time)/60);
                    echo "<script>alert('账号已锁定,请于".$min."分钟后登陆');location.href='/admin/login';</script>";die;
                }
                //错误次数清零 时间改为null
                $res=Login::where('id',$info['id'])->update(['error_num'=>0,'last_error_time'=>null]);
                echo "<script>alert('登陆成功');location.href='/admin';</script>";
            }else{
                //密码错误超过1小时
                if(($time-$last_error_time)>=3600){
                    $res=Login::where('id',$info['id'])->update(['error_num'=>1,'last_error_time'=>$time]);
                    if($res){
                        echo "<script>alert('密码错误,还有两次机会');location.href='/admin/login';</script>";die;
                    }
                }
                //密码错误3次
                if($error_num>=3){
                    echo "<script>alert('账号已锁定请于1小时登陆');location.href='/admin/login';</script>";die;
                }else{
                    $res=Login::where('id',$info['id'])->update(['error_num'=>$error_num+1,'last_error_time'=>$time]);
                    if($res){
                        if($error_num==2){
                            echo "<script>alert('账号已锁定请于1小时登陆');location.href='/admin/login';</script>";die;
                        }
                        echo "<script>alert('密码错误,还有".(3-($error_num+1))."次机会');location.href='/admin/login';</script>";die;
                    }
                }
            }

        }else{
            echo "<script>alert('账户或密码错误');location.href='/admin/login';</script>";die;
        }

    }

}
