@extends('common.layout')


@section('title', $content['title'])

@section('css')
@parent

<link rel="stylesheet" href="{{ url('video-js/video-js.css') }}">
<link rel="stylesheet" href="{{ url('player/video_js_danmaku.css') }}">

@endsection


@section('content')

    <div class="panel panel-default">
        <div class="panel-body text-center">
            <h3>{{ $content['title'] }}</h3>

            <p>播放: {{ $content['play'] }} 分类: {{ $content['typename'] }} 弹幕: {{ $content['video_review'] }}</p>
        </div>
    </div>


    <div class="well wb_video_content">
        <div class="row text-center wb_video_select" id="video_container">
            <div class="btn-group" role="group" aria-label="画质选择">
                <button type="button" id="btn_launch_low" class="btn btn-default">低画质</button>
                <button type="button" id="btn_launch_mid" class="btn btn-default">标准画质</button>
                <button type="button" id="btn_launch_high" class="btn btn-default">高画质</button>
            </div>

            <div id="video_info" aid="{{ $aid }}" cid="{{ $content['cid'] }}"></div>

            <div class="text-center" id="loading"></div>

            <div class="col-md-10 col-md-offset-1 text-center">
                <div class="abp" id="player_content">
                    <div class="dialog">
                        <video id="player" class="video-js vjs-default-skin"
                               controls preload="auto" width="900" height="600"
                               poster="{{ $content['pic'] }}" data-setup="{}">
                            <p class="vjs-no-js">你的浏览器不支持Html5</p>
                        </video>
                    </div>
                </div>
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


<script src="{{ url('video-js/video.js') }}"></script>
<script src="{{ url('player/CommentCoreLibrary.min.js') }}"></script>
<script src="{{ url('player/ABPLibxml.js') }}"></script>
<script src="{{ url('player/video_js_danmaku.js') }}"></script>
<script src="{{ url('player/player.js') }}"></script>


@endsection
