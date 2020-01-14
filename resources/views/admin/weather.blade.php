
@extends('layouts.app')

@section('title', '一周气温展示')

@section('content')

<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8"><link rel="icon" href="https://jscdn.com.cn/highcharts/images/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        /* css 代码  */
    </style>
    <script src="https://code.highcharts.com.cn/highcharts/highcharts.js"></script>
    <script src="https://code.highcharts.com.cn/highcharts/highcharts-more.js"></script>
    <script src="https://code.highcharts.com.cn/highcharts/modules/exporting.js"></script>
    <script src="https://img.hcharts.cn/highcharts-plugins/highcharts-zh_CN.js"></script>
    <script src="/static/hadmin/js/jquery-3.2.1.min.js"></script>
</head>
<body>
<h2>一周气温展示</h2>
城市:<input type="text" name="city">
<input type="submit" value="搜索" id="search">

<hr>

<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

<script>
    var chart = Highcharts.chart('container', {
        chart: {
            type: 'columnrange', // columnrange 依赖 highcharts-more.js
            inverted: true
        },
        title: {
            text: ''
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            categories: ['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月']
        },
        yAxis: {
            title: {
                text: '温度 ( °C )'
            }]
        },
        tooltip: {
            valueSuffix: '°C'
        },
        plotOptions: {
            columnrange: {
                dataLabels: {
                    enabled: true,
                    formatter: function () {
                        return this.y + '°C';
                    }
                }
            }
        },
        legend: {
            enabled: false
        },
        series: [{
            name: '温度',
            data: [
                [-9.7, 9.4],
                [-8.7, 6.5],
                [-3.5, 9.4],
                [-1.4, 19.9],
                [0.0, 22.6],
                [2.9, 29.5],
                [9.2, 30.7],
                [7.3, 26.5],
                [4.4, 18.0],
                [-3.1, 11.4],
                [-5.2, 10.4],
                [-13.5, 9.8]
            ]
        }]
    });
</script>
</body>
</html>
@endsection

<script>

    $(document).ready(function(){

        $("#search").on('click',function(){
            alert(123);
            return false;
            var city =  $('[name="city"]').val();
            console.log(city);

        });

    });

</script>


