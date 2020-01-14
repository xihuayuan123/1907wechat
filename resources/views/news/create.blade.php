
    @extends('layouts.app')

    @section('title', '新闻管理--添加')

    @section('content')

    <h1 align="center">新闻添加</h1><a href="{{url('news/index')}}">新闻展示</a>

    <hr>

    <form class="form-horizontal" role="form" action="{{url('/news/store')}}" method="post">

        <div class="form-group">
            <label for="firstname" class="col-sm-2 control-label">新闻标题</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="firstname" name="new_title" placeholder="请输入新闻标题">
            </div>
        </div>

        <div class="form-group">
            <label for="firstname" class="col-sm-2 control-label">新闻内容</label>
            <div class="col-sm-9">
                <textarea class="form-control" id="firstname" name="new_content" placeholder="请输入新闻内容"></textarea>
            </div>
        </div>

        <div class="form-group">
            <label for="firstname" class="col-sm-2 control-label">新闻记者</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="firstname" name="new_account" placeholder="请输入新闻作者">
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default">添加</button>
            </div>
        </div>

    </form>
    @endsection


