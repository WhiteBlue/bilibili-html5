@extends('common.layout')

@section('title', '关于BiliBili-Html5')

@section('css')
    @parent

@endsection


@section('content')

    <div class="panel panel-default">
        <div class="panel-body text-center">
            <h3>吐槽板</h3>
        </div>
        <div class="well">
            <h4 class="text-center">> 血泪更新史 <</h4>
            <h4>2015.7</h4>
            <blockquote>
                <p>为了上手Laravel框架，BiliBili-Html5企划开始，尝鲜使用lumen，初版使用ABplayer</p>
                <footer>嗯，只是简单做一做</footer>
            </blockquote>

            <h4>2015.8</h4>
            <blockquote>
                <p>加入分类，搜索功能，首页美化</p>
                <footer>之前的实在看不过去了233</footer>
            </blockquote>

            <h4>2015.9</h4>
            <blockquote>
                <p>完成弹幕播放器</p>
                <footer>闲来无事学学JS</footer>
            </blockquote>

            <h4>2015.10</h4>
            <blockquote>
                <p>重新买了位于国内的服务器做中转</p>
                <footer>可以看版权番啦</footer>
            </blockquote>

            <h4>2015.11</h4>
            <blockquote>
                <p>重构部分页面,清晰度增加为三个</p>
                <footer>小更新~</footer>
            </blockquote>


            <h4>2015.12</h4>
            <blockquote>
                <p>页面重构完成,加入番剧列表,加入专题查看功能,修复若干bug</p>
                <footer>全功能版完成~</footer>
            </blockquote>

            <h4>更新预定</h4>
            <blockquote>
                <p>弹幕播放器继续调教,bug修正</p>
            </blockquote>

        </div>
    </div>


    <div class="ds-thread" data-thread-key="about" data-title="about" data-url="{{ url('/about') }}"></div>

@endsection

@section('javascript')
    @parent

    <script type="text/javascript">
        var duoshuoQuery = {short_name: "bili"};
        (function () {
            var ds = document.createElement('script');
            ds.type = 'text/javascript';
            ds.async = true;
            ds.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') + '//static.duoshuo.com/embed.js';
            ds.charset = 'UTF-8';
            (document.getElementsByTagName('head')[0]
            || document.getElementsByTagName('body')[0]).appendChild(ds);
        })();
    </script>

@endsection
