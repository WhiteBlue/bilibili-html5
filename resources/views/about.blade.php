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

            <h4>2015.12</h4>
            <blockquote>
                <p>搜索服务完善,弹幕播放器调教</p>
            </blockquote>

            <h4>2015.1</h4>
            <blockquote>
                <p>完成Rect版本,移动端专属优化,service用Golang重构,迁移至DaoCloud</p>
            </blockquote>

            <h4>2015.1</h4>
            <blockquote>
                <p>搜索接口修正,web端更新,分P-bug修复,添加flv格式支持,项目引入bower管理</p>
            </blockquote>

        </div>
    </div>


    <div id="disqus_thread"></div>
    <script>
        (function () {
            var d = document, s = d.createElement('script');
            s.src = '//shiroblue.disqus.com/embed.js';
            s.setAttribute('data-timestamp', +new Date());
            (d.head || d.body).appendChild(s);
        })();
    </script>
    <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments
            powered by Disqus.</a></noscript>
@endsection

@section('javascript')
    @parent


@endsection
