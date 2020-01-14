@extends('layouts.app')

@section('title', '渠道管理--统计图表')

@section('content')

    <!-- 图表容器 DOM -->
    <div align="center" id="container" style="width: 950px;height:450px;"></div>
    <!-- 引入 highcharts.js -->
    <script src="http://cdn.highcharts.com.cn/highcharts/highcharts.js"></script>

    <script>
        // 图表配置
        var options = {
            chart: {
                type: 'bar'                          //指定图表的类型，默认是折线图（line）
            },
            title: {
                text: '渠道管理--统计图表'                 // 标题
            },
            xAxis: {
                categories: [<?php echo $xStr ?>]   // x 轴分类
            },
            yAxis: {
                title: {
                    text: '关注人数'                // y 轴标题
                }
            },
            series: [
                {
                    name: '人数',
                    data: [<?php echo $yStr ?>]
                }
            ]
        };
        // 图表初始化函数
        var chart = Highcharts.chart('container', options);
    </script>


@endsection
