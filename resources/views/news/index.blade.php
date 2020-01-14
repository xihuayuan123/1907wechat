    @extends('layouts.app')

    @section('title', '新闻管理--添加')

    @section('content')

    <h1 align="center">新闻展示</h1> <a href="{{url('/news/create')}}">新闻添加</a>

    <hr>

    {{--搜索--}}
    <form>
        <input type="text"  name="new_title" value="{{$query['new_title']??''}}" placeholder="请输入新闻标题">
        <input type="text"  name="new_account" value="{{$query['new_account']??''}}" placeholder="请输入新闻作者">
        <input type="submit" value="搜索">
    </form>

    <br>

    <table class="table table-hover table-bordered">

        <thead>
        <tr>
            <th>新闻id</th>
            <th>新闻标题</th>
            <th>新闻内容</th>
            <th>新闻记者</th>
            <th>添加时间</th>
            <th>操作</th>
        </tr>
        </thead>

        <tbody>
            @foreach( $data as $v )
                <tr>
                    <td>{{$v['new_id']}}</td>
                    <td>{{$v['new_title']}}</td>
                    <td>{{$v['new_content']}}</td>
                    <td>{{$v['new_account']}}</td>
                    <td>{{ date('Y-m-d H:i:s',$v['new_time'])}}</td>
                    <td>
                        <a href="{{url('/news/edit',$v['new_id'])}}" class="btn btn-info">编辑</a>
                        <a href="{{url('/news/delete',$v['new_id'])}}" class="btn btn-danger">删除</a>
                    </td>
                </tr>
            @endforeach
        </tbody>

        <tr>
            <td colspan="7">{{ $data->appends($query)->links() }}</td>
        </tr>


    </table>
    @endsection


