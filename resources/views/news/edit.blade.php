<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>新闻编辑</title>

    <link rel="stylesheet" href="/static/hadmin/css/bootstrap.min.css">
    <script src="/static/hadmin/js/jquery-3.2.1.min.js"></script>
    <script src="/static/hadmin/js/bootstrap.min.js"></script>

</head>
<body>

    <h1 align="center">新闻编辑</h1> <a href="{{url('news/index')}}">新闻展示</a>

    <hr>

    <form class="form-horizontal" role="form" action="{{url('/news/update/'.$data->new_id)}}" method="post">

        <div class="form-group">
            <label for="firstname" class="col-sm-2 control-label">新闻标题</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="firstname" name="new_title" value="{{$data->new_title}}" placeholder="请输入新闻标题">
            </div>
        </div>

        <div class="form-group">
            <label for="firstname" class="col-sm-2 control-label">新闻内容</label>
            <div class="col-sm-9">
                <textarea class="form-control" id="firstname" name="new_content" placeholder="请输入新闻内容">{{$data->new_content}}</textarea>
            </div>
        </div>

        <div class="form-group">
            <label for="firstname" class="col-sm-2 control-label">新闻记者</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="firstname" name="new_account" value="{{$data->new_account}}" placeholder="请输入新闻作者">
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default">编辑</button>
            </div>
        </div>

    </form>

</body>
</html>

