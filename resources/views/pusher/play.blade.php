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

        <div class="container" id="father">
            <div class="row text-center">

                <ul class="pager" id="player_quality_select">
                    <li class="prev" id="li_1"><a href="javascript:void(0);" id="play_1"> 普通画质 </a></li>
                    <li class="next" id="li_2"><a href="javascript:void(0);" id="play_2"> 流量杀手 </a></li>
                </ul>

            </div>

            <div class="row text-center" id="player_part_select">
                @if($info->pages>1)
                    @for($i=1;$i<=$info->pages;$i++)
                        <a class="btn btn-info" href="{{ url('/view/'.$aid.'?page='.$i) }}">分集:{{ $i }}</a>
                    @endfor
                @endif
            </div>
        </div>

        <div class="text-center" id="loading">
        </div>

        <div class="abp" id="player_content">
            <div class="dialog">
                <video id="player" class="video-js vjs-default-skin" controls
                       preload="auto" width="100%" height="600" data-setup="{}">
                    <p class="vjs-no-js">升级下浏览器吧..</p>
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

    <script>
        load_object = {
            data_insert: [
                '插入栓 插入',
                '播放传导系统 准备接触',
                '探针插入 完毕',
                '神经同调装置在基准范围内',
                '插入栓注水',
                '播放器界面连接',
                '同步率为100%'
            ],
            insert_i: 0,
            main_container: null,
            loading_element: null,
            player: null,
            aid: '{{ $info->aid }}',
            cid: '{{ $info->cid }}',
            page: '{{ $page }}',
            danmaku_xml: 'http://comment.bilibili.cn/{{ $info->cid }}.xml',
            pic: '{{ $info->pic }}'
        };
    </script>
    <script src="{{ url('video-js/video.js') }}"></script>
    <script src="{{ url('js/CommentCoreLibrary.min.js') }}"></script>
    <script src="{{ url('js/ABPLibxml.js') }}"></script>
    <script src="{{ url('js/video_js_danmaku.js') }}"></script>
    <script src="{{ url('js/player_launch.js') }}"></script>

@endsection