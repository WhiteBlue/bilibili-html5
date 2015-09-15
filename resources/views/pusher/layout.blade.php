<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BiliBiliH5</title>

    @section('css')
        <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link href="{{ url('css/bili.css') }}" rel="stylesheet">
        <link href="{{ url('css/flat-ui.css') }}" rel="stylesheet">

        <!--[if lt IE 9]>
        <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    @show

</head>
<body>


<div class="container">

    <nav class="navbar navbar-inverse" role="navigation">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-01">
                <span class="sr-only">Toggle navigation</span>
            </button>
            <a class="navbar-brand" href="{{ url('/') }}">BiliBiliH5</a>
        </div>
        <div class="collapse navbar-collapse" id="navbar-collapse-01">
            <ul class="nav navbar-nav">
                <li><a href="{{ url('/') }}">首页</a></li>
                <li><a href="{{ url('/list') }}">分区</a></li>
                <li><a href="{{ url('/new') }}">新番列表</a></li>
                <li><a href="{{ url('/about') }}">关于BiliBiliH5</a></li>
            </ul>
        </div>
    </nav>

    @if(Session::has('message'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            {{ Session::get('message') }}
        </div>
    @endif


    @yield('content')


    <footer class="footer">
        <p class="text-center">&copy; "BiliPusher" Work by <a href="http://blog.whiteblue.xyz">WhiteBlue</a></p>
    </footer>

</div>


@section('javascript')
    <script src="{{ url('js/jquery-2.1.3.min.js') }}"></script>
    <script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="{{ url('js/flat-ui.min.js') }}"></script>
@show

</body>
</html>