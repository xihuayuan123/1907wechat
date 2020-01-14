
    @extends('layouts.app')

    @section('title', '后台--登录')

    @section('content')

    <div class="middle-box text-center loginscreen  animated fadeInDown">
        <div>
            <div>
                <h1 class="logo-name">h</h1>
            </div>
            <h3>欢迎使用 hAdmin</h3>

            <form class="m-t" role="form" action="{{url('/admin/login/logindo')}}">
                <div class="form-group">
                    <input type="email" class="form-control" name="account" placeholder="用户名">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="pwd" placeholder="密码">
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">登 录</button>

                <p class="text-muted text-center"> <a href="login.html#"><small>忘记密码了？</small></a> | <a href="register.html">注册一个新账号</a>
                </p>

            </form>
        </div>
    </div>

    @endsection

