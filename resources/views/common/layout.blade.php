<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>BiliBiliHtml5-@yield('title')</title>

    <meta name="keywords" content="BiliBili,BiliBili助手">
    <meta name="description" content="BiliBili-html5，替换视频源，纯Html5播放器">


    @section('css')
        <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">

        <link rel="stylesheet" href="{{ url('css/site.css') }}">

        <!--[if lt IE 9]>
        <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    @show

</head>
<body>


<div class="container">
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ url('/') }}">BiliBili-Html5</a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/') }}"> 首页 <span class="sr-only">(current)</span></a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false"> 分类 <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            @foreach(\App\Utils\BiliBiliHelper::getSorts() as $sort_key=>$sort_value)
                                <li><a href="{{ url('/sort/'.$sort_key) }}">{{ $sort_value }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    <li><a href="javascript:void(0)"> 新番 </a></li>
                    <li><a href="{{ url('/about') }}"> 关于 </a></li>

                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <form action="{{ url('search') }}" method="get" class="navbar-form navbar-left" role="search">
                        <div class="form-group">
                            <input type="text" name="keyword" class="form-control" placeholder="搜索相关视频">
                        </div>
                        <button type="submit" class="btn btn-default">搜索</button>
                    </form>
                </ul>
            </div>
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

    <footer class="wb_footer">
        <div class="container text-center">
            <p class="text-center">&copy; "BiliPusher" Work by <a href="http://blog.whiteblue.xyz">WhiteBlue</a></p>

            <p class="text-center">Mail : whiteblue616@icloud.com</p>

            <script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");
                document.write(unescape("%3Cspan id='cnzz_stat_icon_1256627943'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s4.cnzz.com/z_stat.php%3Fid%3D1256627943%26show%3Dpic' type='text/javascript'%3E%3C/script%3E"));</script>
        </div>
    </footer>


</div>


@section('javascript')
    <script src="http://libs.useso.com/js/jquery/2.1.1/jquery.min.js"></script>
    <script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="{{ url('js/site.js') }}"></script>
@show

</body>
</html>