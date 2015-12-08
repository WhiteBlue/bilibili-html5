@extends('common.layout')


@section('title', $content['title'])

@section('css')
    @parent

    <link rel="stylesheet" href="{{ url('danmakuPlayer/dist/video-js.min.css') }}">
    <link rel="stylesheet" href="{{ url('danmakuPlayer/danmaku_player.css') }}">

@endsection


@section('content')

    <div class="panel panel-default">
        <div class="panel-body text-center">
            <h3>{{ $content['title'] }}</h3>

            <p>播放: {{ $content['play'] }} 分类: {{ $content['typename'] }} 弹幕: {{ $content['video_review'] }}</p>
        </div>
    </div>


    <div class="well wb_video_content">
        @if($content['pages']>1)
            <nav>
                <ul class="pager">
                    @if($page!=1)
                        <li><a href="{{ url('/view/'.$aid.'?page='.($page-1)) }}">上一P</a></li>
                    @endif
                    <li><a href="javascript:viod(0)">{{ $content['partname'] }}</a></li>
                    @if($page<$content['pages'])
                        <li><a href="{{ url('/view/'.$aid.'?page='.($page+1)) }}">下一P</a></li>
                    @endif
                </ul>
            </nav>
        @endif


        <div class="row text-center wb_video_select" id="video_container">
            <div class="btn-group" role="group" aria-label="画质选择">
                <button type="button" id="btn_launch_low" class="btn btn-default">低画质</button>
                <button type="button" id="btn_launch_mid" class="btn btn-default">标准画质</button>
                <button type="button" id="btn_launch_high" class="btn btn-default">高画质</button>
            </div>

            <div id="video_info" aid="{{ $aid }}" cid="{{ $content['cid'] }}"></div>


            <div class="video_block" style="display: none">
                <div class="loading_frame" id="loading_dialog"></div>
                <video id="danmaku_player" class="video-js vjs-default-skin" controls
                       poster="{{ $content['pic'] }}"
                       preload="auto" width="900" height="600">
                    <p class="vjs-no-js">你的浏览器不支持Html5</p>
                </video>
            </div>

        </div>


    </div>

    <div class="row">

        <div class="col-sm-3">
            <div class="thumbnail text-center" style="height: 300px">
                <img src="{{ $content['face'] }}" alt="...">

                <div class="caption">
                    <h3 style="font-size: 19px">{{ $content['author'] }}</h3>

                    <p>硬币 : {{ $content['coins'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="panel panel-default wb_video_brief" style="">
                <div class="panel-body text-center">
                    <div class="media">
                        <div class="media-body">
                            <h4 class="media-heading">简介</h4>

                            <p class="wb_video_brief_p">
                                {{ $content['description'] }}
                            </p>

                            <p>
                                {{ $content['tag'] }}
                            </p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('javascript')
    @parent

    <script src="{{ url('danmakuPlayer/dist/video.min.js') }}"></script>
    <script src="{{ url('danmakuPlayer/CommentCoreLibrary.min.js') }}"></script>
    <script src="{{ url('danmakuPlayer/BilibiliFormat.js') }}"></script>
    <script src="{{ url('danmakuPlayer/videojs_ABdm.js') }}"></script>
    <script src="{{ url('danmakuPlayer/danmaku_player.js') }}"></script>

    <script>
        $(document).ready(function () {
            var id_container = $('#video_info');
            var aid = id_container.attr('aid');
            var cid = id_container.attr('cid');

            window.videoPlayer = loadPlayer('danmaku_player', '#loading_dialog');

            function loadVideo(video, danmaku) {
                $('.video_block').fadeIn();
                videoPlayer.loadVideo(video);
                videoPlayer.loadDanmaku(danmaku);
                videoPlayer.loadStart();
            }

            $('#btn_launch_low').click(function () {
                $.get("/video/0?aid=" + aid + "&cid=" + cid,
                        function (data, status) {
                            if (data.code == 'success') {
                                loadVideo(data.content, 'http://comment.bilibili.cn/' + cid + '.xml');
                            } else {
                                videoPlayer.addLoadingText('出现未知异常,同步率下降,请尝试刷新页面');
                            }
                        }
                );
            });

            $('#btn_launch_mid').click(function () {
                $.get("/video/1?aid=" + aid + "&cid=" + cid,
                        function (data, status) {
                            if (data.code == 'success') {
                                loadVideo(data.content, 'http://comment.bilibili.cn/' + cid + '.xml');
                            } else {
                                videoPlayer.addLoadingText('出现未知异常,同步率下降,请尝试刷新页面');
                            }
                        }
                );
            });

            $('#btn_launch_high').click(function () {
                $.get("/video/3?aid=" + aid + "&cid=" + cid,
                        function (data, status) {
                            if (data.code == 'success') {
                                loadVideo(data.content, 'http://comment.bilibili.cn/' + cid + '.xml');
                            } else {
                                videoPlayer.addLoadingText('出现未知异常,同步率下降,请尝试刷新页面');
                            }
                        }
                );
            });
        });

    </script>


@endsection
