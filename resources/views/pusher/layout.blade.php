<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BiliPusher</title>

    @section('css')
        <link href="{{ url('bootstrap/css/bootstrap.css') }}" rel="stylesheet">
        <link href="{{ url('css/bili.css') }}" rel="stylesheet">
        <link href="{{ url('css/flat-ui.min.css') }}" rel="stylesheet">

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
            <a class="navbar-brand" href="{{ url('/') }}">BiliPusher</a>
        </div>
        <div class="collapse navbar-collapse" id="navbar-collapse-01">
            <ul class="nav navbar-nav">
                <li><a href="{{ url('/') }}">首页</a></li>
                <li><a href="{{ url('/me') }}">我的关注</a></li>
                <li><a href="{{ url('/about') }}">关于Pusher</a></li>
                <li><a href="{{ url('/') }}">关于我</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">

                @if (Auth::guest())
                    <li><a href="{{ url('/auth/login') }}">登陆</a></li>
                    <li><a href="{{ url('/auth/register') }}">注册</a></li>
                @else
                    <li><a href='#'>{{ Auth::user()->name }}</a></li>
                    <li><a href="{{ url('/auth/logout') }}">注销</a></li>
                @endif
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
    <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <script src="{{ url('bootstrap/js/bootstrap.js') }}"></script>
    <script src="{{ url('js/flat-ui.min.js') }}"></script>
@show

</body>
</html>