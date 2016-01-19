<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>BH5-@yield('title')</title>

    <meta name="keywords" content="BiliBili,BiliBili助手">
    <meta name="description" content="BiliBili-html5，替换视频源，纯Html5播放器">


    @section('css')
        <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">

        <link rel="stylesheet" href="{{ url('css/site.min.css') }}">

        <!--[if lt IE 9]>
        <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
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
                            @foreach(\App\Utils\BiliBiliHelper::$sorts as $sort_key=>$sort_value)
                                <li><a href="{{ url('/sort/'.$sort_key) }}">{{ $sort_value }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    <li><a href="{{ url('/bangumi') }}"> 新番 </a></li>
                    <li><a href="{{ url('/about') }}"> 关于 </a></li>
                    <li><a href="http://mobile.shiroblue.cn"> 移动端 </a></li>
                    <li><a href="http://blog.shiroblue.cn"> Blog </a></li>

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

    <div class="clear"></div>
    <footer class="footer">
        <p>Designed and built by <a href="http://twitter.com/mdo" target="_blank">WhiteBlue</a>.
        </p>

        <p>Code licensed under <a href="http://opensource.org/licenses/mit-license.php" target="_blank">MIT License</a>
        </p>
        <a href="http://www.shiroblue.cn">Blog</a>·
        <a href="https://github.com/WhiteBlue/bilibili-html5">Project</a>·
        <script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");
            document.write(unescape("%3Cspan id='cnzz_stat_icon_1256627943'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s4.cnzz.com/z_stat.php%3Fid%3D1256627943' type='text/javascript'%3E%3C/script%3E"));</script>
    </footer>

</div>


@section('javascript')
    <script src="http://cdn.bootcss.com/jquery/2.2.0/jquery.min.js"></script>
    <script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <script src="{{ url('js/main.min.js') }}"></script>
@show

</body>
</html>