@extends('layouts.app')

@section('title', '渠道管理--添加')

@section('content')

    <h2 align="center">渠道管理--添加</h2>

    <hr>

    <form class="form-horizontal" role="form" action="{{url('/admin/channel_store')}}" method="post">

        <div class="form-group">
            <label for="firstname" class="col-sm-1 control-label">渠道名称</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="firstname" name="channel_name" placeholder="请输入素材名称">
            </div>
        </div>

        <div class="form-group">
            <label for="firstname" class="col-sm-1 control-label">渠道标识</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="firstname" name="channel_status" placeholder="请输入素材名称">
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-1 col-sm-10">
                <button type="submit" class="btn btn-default">添加</button>
            </div>
        </div>

    </form>

@endsection
