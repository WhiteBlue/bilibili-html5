<!DOCTYPE html>
<html lang="zh-CN">

<script>
    var _hmt = _hmt || [];
    (function() {
        var hm = document.createElement("script");
        hm.src = "//hm.baidu.com/hm.js?e4c88c22bb156d74d86d6226574daf22";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    })();
</script>


<head>
    <meta charset="UTF-8">
    <title>BiliBili-Html5</title>

    <meta name="keywords" content="BiliBili,BiliBili助手">
    <meta name="description" content="BiliBili-html5，视频源解析，纯Html5播放器">

    @section('css')
        <link rel="stylesheet" href="{{ url('/styles/main.css') }}">
    @show
</head>
<body>

<div id="main-header">
    <div class="main-header-nav">
        <div class="main-header-image"
             style="background-image: url('/images/bg.png');"></div>
        <div class="header-container needstick">
            <ul class="main-header-nav-body">
                <li class="nav-li floatleft now">
                    <a href="{{ url('/') }}">首页</a>
                </li>

                <li class="nav-li floatleft">
                    <a href="{{ url('/sort/1') }}">动画</a>
                    <div class="nav-li-list">
                        <a href="{{ url('/sort/24') }}">MAD·AMV</a>
                        <a href="{{ url('/sort/25') }}">MMD·3D</a>
                        <a href="{{ url('/sort/47') }}">短片·手书·配音</a>
                        <a href="{{ url('/sort/27') }}">综合</a>
                    </div>
                </li>

                <li class="nav-li floatleft">
                    <a href="{{ url('/sort/13') }}">番剧</a>
                    <div class="nav-li-list">
                        <a href="{{ url('/sort/33') }}">连载动画</a>
                        <a href="{{ url('/sort/32') }}">完结动画</a>
                        <a href="{{ url('/sort/152') }}">官方延伸</a>
                        <a href="{{ url('/sort/153') }}">国产动画</a>
                    </div>
                </li>

                <li class="nav-li floatleft">
                    <a href="{{ url('/sort/3') }}">音乐</a>
                    <div class="nav-li-list">
                        <a href="{{ url('/sort/31') }}">翻唱</a>
                        <a href="{{ url('/sort/30') }}">VOCALOID·UTAU</a>
                        <a href="{{ url('/sort/29') }}">三次元音乐</a>
                        <a href="{{ url('/sort/28') }}">同人音乐</a>
                        <a href="{{ url('/sort/54') }}">OP/ED/OST</a>
                        <a href="{{ url('/sort/130') }}">音乐选集</a>
                    </div>
                </li>

                <li class="nav-li floatleft">
                    <a href="{{ url('/sort/129') }}">舞蹈</a>
                    <div class="nav-li-list">
                        <a href="{{ url('/sort/20') }}">宅舞</a>
                        <a href="{{ url('/sort/154') }}">三次元舞蹈</a>
                        <a href="{{ url('/sort/156') }}">舞蹈教程</a>
                    </div>
                </li>

                <li class="nav-li floatleft">
                    <a href="{{ url('/sort/4') }}">游戏</a>
                    <div class="nav-li-list">
                        <a href="{{ url('/sort/17') }}">单机联机</a>
                        <a href="{{ url('/sort/65') }}">网游·电竞</a>
                        <a href="{{ url('/sort/136') }}">音游</a>
                        <a href="{{ url('/sort/19') }}">Mugen</a>
                        <a href="{{ url('/sort/121') }}">GMV</a>
                    </div>
                </li>

                <li class="nav-li floatleft">
                    <a href="{{ url('/sort/36') }}">科技</a>
                    <div class="nav-li-list">
                        <a href="{{ url('/sort/37') }}">纪录片</a>
                        <a href="{{ url('/sort/124') }}">趣味科普人文</a>
                        <a href="{{ url('/sort/122') }}">野生技术协会</a>
                        <a href="{{ url('/sort/39') }}">演讲·公开课</a>
                        <a href="{{ url('/sort/95') }}">数码</a>
                        <a href="{{ url('/sort/98') }}">机械</a>
                    </div>
                </li>

                <li class="nav-li floatleft">
                    <a href="{{ url('/sort/5') }}">娱乐</a>
                    <div class="nav-li-list">
                        <a href="{{ url('/sort/153') }}">搞笑</a>
                        <a href="{{ url('/sort/138') }}">生活</a>
                        <a href="{{ url('/sort/75') }}">动物圈</a>
                        <a href="{{ url('/sort/76') }}">美食圈</a>
                        <a href="{{ url('/sort/71') }}">综艺</a>
                        <a href="{{ url('/sort/137') }}">娱乐圈</a>
                        <a href="{{ url('/sort/131') }}">Korea相关</a>
                    </div>
                </li>

                <li class="nav-li floatleft">
                    <a href="{{ url('/sort/119') }}">鬼畜</a>
                    <div class="nav-li-list">
                        <a href="{{ url('/sort/22') }}">鬼畜调教</a>
                        <a href="{{ url('/sort/26') }}">音MAD</a>
                        <a href="{{ url('/sort/126') }}">人力VOCALOID</a>
                        <a href="{{ url('/sort/127') }}">教程演示</a>
                    </div>
                </li>

                <div class="header-search floatright">
                    <form action="{{ url('/search') }}" method="post">
                        <input name="keyword" placeholder="这里搜索">
                        <input type="submit" value="搜 索" title="搜索" class="btn-search">
                    </form>
                </div>
            </ul>
        </div>
    </div>
</div>


@yield('content')


<div id="footer">
    <div class="area-inner">
        <div class="about-block floatleft">
            <div class="about-item left floatleft">
                <div class="about-title">About</div>
                <div class="about-links">
                    <a href="http://www.bilibili.com">BiliBili弹幕视频网</a>
                    <a href="https://github.com/WhiteBlue/bilibili-html5/blob/master/update.md">更新日志</a>
                    <a href="https://github.com/WhiteBlue/bilibili-html5">项目地址</a>
                </div>
            </div>
            <div class="about-item floatleft">
                <div class="about-title">WhiteBlue</div>
                <div class="about-links">
                    <a href="http://blog.shiroblue.cn">Blog</a>
                    <a href="https://github.com/WhiteBlue">Github</a>
                </div>
            </div>
            <div class="about-item right floatleft">
                <div class="about-title">空位</div>
                <div class="about-links">
                    <a href="#">没想好放什么orz</a>
                </div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>

@section('javascript')
    <script type="text/javascript" src="http://cdn.bootcss.com/jquery/2.2.0/jquery.min.js"></script>
    <script type="text/javascript" src="{{ url('/js/stickup.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('/js/app.js') }}"></script>
@show

</body>
</html>