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
        <style type="text/css">
            .shape{width:240px; height: 240px; position:fixed!important;z-index: 2;
                position:absolute; right:5px; bottom:5px!important; bottom:auto;
                top: expression(eval(document.compatMode && document.compatMode=='CSS1Compat') ? documentElement.scrollTop+(documentElement.clientHeight - this.clientHeight):document.body.scrollTop+(document.body.clientHeight - this.clientHeight));}
        </style>
        <!--[if lt IE 9]>
        <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    @show
</head>
<body>

<div class="shape" id="float" style="position: static; bottom:20px; float:right">
    <div class="header" style="width:200px; padding: 5px 10px; background-color: #f6f6f6;">
        本站订阅号 微信二维码
    </div>
    <img width="220px" src="http://www.dingxiaoyue.com/public/qr/dingxiaoyue.jpg" alt="本站微信二维码">
</div>

<div class="container">
    <div class="header" style="background-image: url('http://i1.hdslb.com/headers/903fd37bf35e390eba4ec93ac5d9a1ad.jpg');">
        <div class="h-center">
            <a href="/" class="logo" style="background-image: url('http://v.dingxiaoyue.com/images/logo.png');"></a>
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
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a href="/"> 首页 </a></li>
                    <li><a href="{{ url('/bangumi') }}"> 新番 </a></li>
                    @foreach(\App\Utils\BiliBiliHelper::$sorts as $sort_key=>$sort_value)
                    <li><a href="{{ url('/sort/'.$sort_key) }}">{{ $sort_value }}</a></li>
                    @endforeach
                    <li><a href="http://www.dingxiaoyue.com/" target="_blank">主站</a></li>
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

</div>
<footer class="footer">


    <p style="text-align: center;">本站所有信息来源于互联网，用于学习参考使用，版权归原作者所有！</p>
    <p >Powered by <a href="http://www.dingxiaoyue.com" target="_blank">订小阅号</a>|有任何意见或建议请直接提给 wsc449@qq.com</p>
    <p>  Code licensed under <a href="http://opensource.org/licenses/mit-license.php" target="_blank">MIT License</a>
        | <a href="http://www.miibeian.gov.cn/" target="_blank">冀ICP备15022324号-1</a>|
        <script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1256772413'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s95.cnzz.com/stat.php%3Fid%3D1256772413' type='text/javascript'%3E%3C/script%3E"));</script>
    </p>
</footer>

@section('javascript')
    <script src="http://cdn.bootcss.com/jquery/2.2.0/jquery.min.js"></script>
    <script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="{{ url('js/main.min.js') }}"></script>

@show

</body>
</html>