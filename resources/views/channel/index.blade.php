@extends('layouts.app')

@section('title', '渠道管理--展示')

@section('content')

    <h2 align="center">渠道管理--展示</h2>

    <hr>

    <table class="table table-hover table-bordered">

        <thead>
        <tr>
            <th>渠道id</th>
            <th>渠道名称</th>
            <th>渠道标识</th>
            <th>渠道二维码</th>
            <th>关注人数</th>
            <th>操作</th>
        </tr>
        </thead>

        <tbody>
        @foreach($data as $v)
            <tr>
                <td>{{$v->channel_id}}</td>
                <td>{{$v->channel_name}}</td>
                <td>{{$v->channel_status}}</td>
                <td>
                    <img src="https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket={{$v->ticket}}" width="100px;" height="100px;">
                </td>
                <td>{{$v->num}}</td>
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
