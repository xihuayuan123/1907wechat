@extends('layouts.app')

@section('title', '素材管理--添加')

@section('content')

    <h3 align="center">素材管理--添加</h3>

    <hr>

    <form class="form-horizontal" role="form" action="{{url('/admin/media_store')}}" method="post" enctype="multipart/form-data">

        <div class="form-group">
            <label for="firstname" class="col-sm-1 control-label">素材名称</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="firstname" name="media_name" placeholder="请输入素材名称">
            </div>
        </div>

        <div class="form-group">
            <label for="name" class="col-sm-1  control-label">媒体格式</label>
            <div class="col-sm-10">
                <select class="form-control" name="media_format">
                    <option value="">--请选择--</option>
                    <option value="image">图片</option>
                    <option value="voice">语音</option>
                    <option value="video">视频</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="name" class="col-sm-1  control-label">素材类型</label>
            <div class="col-sm-10">
                <select class="form-control" name="media_type">
                    <option value="">--请选择--</option>
                    <option value="1">永久</option>
                    <option value="2">临时</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="firstname" class="col-sm-1 control-label">素材文件</label>
            <div class="col-sm-10">
                <input type="file" class="form-control" id="firstname" name="file">
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-1 col-sm-10">
                <button type="submit" class="btn btn-default">添加</button>
            </div>
        </div>

    </form>

@endsection
