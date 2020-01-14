@extends('layouts.app')

@section('title', '素材管理--展示')

@section('content')

    <h3 align="center">素材管理--展示</h3>

    <hr>

    <table class="table table-hover table-bordered">

        <thead>
        <tr>
            <th>素材名称</th>
            <th>素材格式</th>
            <th>素材类型</th>
            <th>素材文件</th>
            <th>添加时间</th>
            <th>操作</th>
        </tr>
        </thead>

        <tbody>
        @foreach( $data as $v )
        <tr>
            <td>{{$v->media_name}}</td>
            <td>{{$v->media_format}}</td>
            <td>{{$v->media_type == 1 ? "永久素材" : "临时素材"}}</td>
            <td>
                @if( $v->media_format == 'image' )
                    <img src="\{{$v->media_url}}" width="100px;" height="100px;">
                @elseif( $v->media_format == 'voice' )
                    <audio src="\{{$v->media_url}}" controls="controls"></audio>
                @elseif( $v->media_format == 'video' )
                    <video src="\{{$v->media_url}}" controls="controls" width="1px;" height="1px;"></video>
                @endif
            </td>
            <td>{{ date("Y-m-d H:i:s",$v->add_time) }}</td>
            <td>
                <a href="" class="btn btn-info">编辑</a>
                <a href="" class="btn btn-danger">删除</a>
            </td>
        </tr>
        @endforeach
        </tbody>

        <tr>
            <td colspan="7">{{ $data->links() }}</td>
        </tr>

    </table>
@endsection
