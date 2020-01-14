<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\News;
use Illuminate\Support\Facades\Redis;

class NewsController extends Controller
{

    //新闻添加
    public function create(){

        //展示添加
        return view('news.create');

    }

    //执行添加
    public function store( Request $request ){

        //接收表单name值
        $data = $request->input();

        //入库
        $res = News::create([
            'new_title' => $data['new_title'],
            'new_content' => $data['new_content'],
            'new_account' => $data['new_account'],
            'new_time' => time(),
        ]);

        if( !empty($res) ){
            echo "<script>alert('添加成功！');location.href='/news/index'</script>";
        }else if($res){
            echo  "<script>alert('添加失败！');</script>";
        }

    }

    //新闻展示
    public function index( Request $request ){

        //接收搜索值
        $new_title = $request->new_title;
        $new_account = $request->new_account;

        //处理搜索条件
        $where =[];
        if( $new_title ){
            $where[] = ['new_title','like',"%$new_title%"];
        }
        if( $new_account ){
            $where[] = ['new_account','like',"%$new_account%"];
        }


        //查询信息
        $data = News::where($where)->Orderby('new_id','desc')->paginate(2);

        $query = $request->all();

        //展示
        return view('news.index',['data' => $data,'query' => $query]);

    }

    //新闻删除
    public function delete($id){

        $where = [
            ['new_id','=',$id]
        ];
        $res = News::where($where)->delete();
        if( $res ){
            echo "<script>alert('删除成功！');location.href='/news/index'</script>";
        }else if($res){
            echo  "<script>alert('删除失败！');location.href='/news/index'</script>";
        }
    }

    //新闻编辑
    public function edit($id){

        //根据id查询一条数据
        $where = [
            ['new_id','=',$id]
        ];
        $data = News::where($where)->first();

        //新闻编辑
        return view('news.edit',['data' => $data]);
    }

    //执行编辑
    public function update(Request $request,$id ){

        //接收值
        $data = $request->input();
        $where = [
            ['new_id','=',$id]
        ];
        $res = News::where($where)->update( $data );
        if( $res ){
            echo "<script>alert('编辑成功！');location.href='/news/index'</script>";
        }else if($res){
            echo  "<script>alert('编辑失败！');location.href='/news/edit'</script>";
        }

    }

}

