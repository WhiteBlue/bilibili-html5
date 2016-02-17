<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') - 订小阅动漫</title>

    <meta name="keywords" content="订小阅动漫">
    <meta name="description" content="订小阅动漫，纯Html5播放器">


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
                <a class="navbar-brand" href="{{ url('/') }}">订小阅动漫</a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/bangumi') }}"> 新番 </a></li>
                    @foreach(\App\Utils\BiliBiliHelper::$sorts as $sort_key=>$sort_value)
                    <li><a href="{{ url('/sort/'.$sort_key) }}">{{ $sort_value }}</a></li>
                    @endforeach
                    <li><a href="http://www.dingxiaoyue.com" target="_blank">主站</a></li>
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
        <p>  Code licensed under <a href="http://opensource.org/licenses/mit-license.php" target="_blank">MIT License</a>
        </p>
        <p > <a href="http://www.miibeian.gov.cn/" target="_blank">冀ICP备15022324号-1</a>|
            有任何意见或建议请直接提给 wsc449@qq.com|
            <script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1256772413'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s95.cnzz.com/stat.php%3Fid%3D1256772413' type='text/javascript'%3E%3C/script%3E"));</script>
            <script>
                var _hmt = _hmt || [];
                (function() {
                    var hm = document.createElement("script");
                    hm.src = "//hm.baidu.com/hm.js?0a52b0f4565b5ad096a1e36af386a0c4";
                    var s = document.getElementsByTagName("script")[0];
                    s.parentNode.insertBefore(hm, s);
                })();
            </script>
       </p>

       </footer>
</div>


@section('javascript')
    <script src="http://cdn.bootcss.com/jquery/2.2.0/jquery.min.js"></script>
    <script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="{{ url('js/main.min.js') }}"></script>
@show

</body>
</html>