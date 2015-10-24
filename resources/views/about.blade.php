@extends('common.layout')

@section('title', '关于BiliBili-Html5')

@section('css')
    @parent

@endsection


@section('content')

    <div class="panel panel-default">
        <div class="panel-body text-center">
            <h3>血泪更新史</h3>
        </div>
        <div class="well">
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
                <p>里程碑，成功融合video.js+CCM，完成了目前最优秀（好吧我滚）的Html5弹幕播放器</p>
                <footer>闲来无事学学JS</footer>
            </blockquote>

            <h4>2015.9.13</h4>
            <blockquote>
                <p>受困于PHP curl的捉鸡，开始考虑结构异构化，使用Java构建RestFul服务负责请求B站API</p>
                <footer>又开始写Java啦~</footer>
            </blockquote>


            <h4>2015.10.20</h4>
            <blockquote>
                <p>基于SparkJava的RestFul服务"BiliBiliClientCore"上线，开始重构主站代码。弃用FlatUI</p>
                <footer>整天想着重构挖坑....</footer>
            </blockquote>

            <h4>2015.10.22</h4>
            <blockquote>
                <p>弃用Mysql，全局使用Redis缓存，Java使用Quartz定期更新Redis</p>
                <footer>轻量化~</footer>
            </blockquote>


            <h4>2015.10.24</h4>
            <blockquote>
                <p>重构进度80%，成功破解版权番，加入HD清晰度</p>
                <footer>里程碑~</footer>
            </blockquote>


        </div>

        <div class="row text-center">
            <a class="btn btn-primary btn-lg" href="https://github.com/WhiteBlue/BiliPusher" role="button">Git</a>
            <a class="btn btn-success btn-lg" href="http://www.shiroblue.cn" role="button">Me</a>
        </div>
    </div>

@endsection

@section('javascript')
    @parent

@endsection
