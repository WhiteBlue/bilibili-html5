@extends('pusher.layout')

@section('css')
    @parent

    <link href="{{ url('video-js/video-js.css') }}" rel="stylesheet">
    <link href="{{ url('css/danmaku_style.css') }}" rel="stylesheet">
    <link href="{{ url('css/video_js_danmaku.css') }}" rel="stylesheet">

@endsection

@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-md-8 text-center">
                <h4>{{ $info->title }}</h4>
                <small><span class="glyphicon glyphicon-tags"> 分区:{{ $info->typename }}</span>&nbsp;&nbsp;&nbsp;<span
                            class="glyphicon glyphicon-play"> 播放:{{ $info->play }}</span>&nbsp;&nbsp;&nbsp;<span
                            class="glyphicon glyphicon-font"> 弹幕:{{ $info->video_review }}</span></small>
            </div>
            <div class="col-md-4 text-center visible-md visible-lg">
                <h3>
                    <a href="http://www.bilibili.com/video/av{{ $aid }}" class="btn btn-success next">去B站看>></a>
                </h3>
            </div>
        </div>
    </div>

    <div class="jumbotron">

        <div class="container">
            <div class="row text-center">
                <ul class="pager">
                    <li class="prev" id="li_1"><a href="#" id="play_1"> 省吃俭用 </a></li>
                    <li class="next" id="li_2"><a href="#" id="play_2"> 流量杀手 </a></li>
                </ul>
            </div>

            @if($info->pages>1)
                <div class="pagination pagination-success">
                    <ul>
                        @for($i=1;$i<=$info->pages;$i++)
                            <li><a href="{{ url('/view/'.$aid.'?page='.$i) }}">分集:{{ $i }}</a></li>
                        @endfor
                    </ul>
                </div>
                <br>
                <br>
            @endif
        </div>

        <div class="container" id="loading" style="display: none">
            <p>正在准备播放</p>

            <p>播放器稳定</p>
        </div>

        <div class="container abp" id="player_content" style="height: 600px;display: none">
            <div class="dialog">
                <video id="player" class="video-js vjs-default-skin" controls
                       preload="auto" width="100%" height="600" poster="MY_VIDEO_POSTER.jpg" data-setup="{}">
                    <p class="vjs-no-js">其实,你的浏览器不支持Html5</p>
                </video>
            </div>
        </div>

    </div>


    <div class="row">
        <div class="col-md-4 text-center visible-md visible-lg">
            <div class="span3">
                <div class="tile">
                    <img class="tile-image" alt="" src="{{ $info->face }}">

                    <h3 class="tile-title">{{ $info->author }}</h3>

                    <p>{{ $info->tag }}</p>
                    <a class="btn btn-primary btn-large btn-block" href="#">关注Ta</a>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="list-group">

                <a href="#" class="download list-group-item"><span class="glyphicon glyphicon-save"></span>
                    点我下载Part1</a>
            </div>

            <div class="panel panel-default">
                <div class="panel-body">
                    <p>{{ $info->description }}</p>
                </div>
            </div>


        </div>

    </div>

@endsection

@section('javascript')
    @parent

    <script src="{{ url('video-js/video.js') }}"></script>
    <script src="{{ url('js/CommentCoreLibrary.min.js') }}"></script>
    <script src="{{ url('js/ABPLibxml.js') }}"></script>
    <script src="{{ url('js/video_js_danmaku.js') }}"></script>

    <script>
        $(document).ready(function () {
            data_insert = [
                '插入栓 插入',
                '播放传导系统 准备接触',
                '探针插入 完毕',
                '神经同调装置在基准范围内',
                '插入栓注水',
                '播放器界面连接',
                '同步率为100%'
            ];

            i = 0;

            $('#player_content').hide();


            $('#play_1').on('click', function () {
                $('#li_1').addClass('disabled');
                $('#loading').show();

                $.get("{{ url('/play/'.$info->cid.'?quality='.'2') }}", function (data, status) {
                    if (data.code == 'success') {
                        $('#player_content').show();

                        var player = loadPlayer('player', data.content.url, 'http://comment.bilibili.cn/{{ $info->cid }}.xml');
                    } else {
                        alert('异常');
                        $('#loading').append('<p style="color: red">ERROR,同步率下降,请刷新页面</p>');
                    }
                });

            });

            $('#play_2').on('click', function () {
                $('#li_2').addClass('disabled');
                $('#loading').show();

                $.get("{{ url('/play/'.$info->cid.'?quality='.'2') }}", function (data, status) {
                    if (data.code == 'success') {
                        var player = loadPlayer('player', data.content.url, 'http://comment.bilibili.cn/{{ $info->cid }}.xml');
                        $('#player_content').show();
                    } else {
                        alert('异常');
                        $('#loading').append('<p style="color: red">出现异常,神经脉冲逆转,同步率下降,请刷新页面</p>');
                    }
                });

            });


        });
    </script>
@endsection