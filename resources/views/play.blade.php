@extends('common.layout')


@section('title', $video['title'])

@section('css')
    <link rel="stylesheet" href="{{ url('components/video.js/dist/video-js.min.css') }}">
    @parent
@endsection


@section('content')

    <div class="row">
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-body text-center">
                    <h3>{{ $video['title'] }}</h3>

                    <p><b>播放</b>: {{ $video['play'] }}
                        <b>分类</b>: {{ $video['typename'] }}
                        <b>时间</b>: {{ $video['created_at'] }}
                        <b>弹幕</b>: {{ $video['video_review'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="video_user text-center">
                <img class="img-circle" src="{{ $video['face'] }}">

                <div class="caption">
                    <p>{{ $video['author'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row text-center" @if(sizeof($video['list'])==1) style="display: none"@endif>
        <nav>
            <ul class="pager">
                @foreach($video['list'] as $index=>$part)
                    <li><a class="video_part_select" cid="{{$part['cid']}}"
                           href="javascript:void(0)">{{ $part['part'] }}</a></li>
                @endforeach
            </ul>
        </nav>
    </div>

    <div class="well wb_video_content">

        <div class="row text-center">
            <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-primary active quality_select" quality="1">
                    <input type="radio" name="options" autocomplete="off" checked>普通
                </label>
                <label class="btn btn-primary quality_select" quality="2">
                    <input type="radio" name="options" autocomplete="off">高清
                </label>
            </div>
        </div>

        <div class="row text-center wb_video_select" id="video_container">
            <div class="video_block">
                <div class="loading_frame" id="loading_dialog" style="display: none"></div>
                <video id="danmu_player" class="video-js vjs-default-skin" controls poster="{{ $video['pic'] }}"
                       preload="auto" width="880" height="580">
                    <p class="vjs-no-js">你的浏览器不支持Html5</p>
                </video>
            </div>

        </div>

    </div>

    <div class="row">
        <div class="col-md-12 col-md-offset-0">
            <div class="panel panel-default wb_video_brief">
                <div class="panel-body text-center">
                    <div class="media">
                        <div class="media-body">
                            <h4 class="media-heading">简介</h4>

                            <p class="wb_video_brief_p">
                                {{ $video['description'] }}
                            </p>
                            <h4 class="media-heading">标签</h4>
                            @foreach(explode(",", $video['tag']) as $part)
                                <span class="label label-info">{{ $part }}</span>&nbsp;
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- UJian Button BEGIN -->
        <div class="ujian-hook"></div>
        <script type="text/javascript">var ujian_config = {num:8,itemTitle:'看过该视频的还喜欢',picSize:110,textHeight:45};</script>
        <script type="text/javascript" src="http://v1.ujian.cc/code/ujian.js?uid=1843026"></script>
        <!-- UJian Button END -->
        <!-- UY BEGIN -->
        <div id="uyan_frame"></div>
        <script type="text/javascript" src="http://v2.uyan.cc/code/uyan.js?uid=1843026"></script>
        <!-- UY END -->
    </div>

@endsection

@section('javascript')
    @parent

    <script src="{{ url('components/video.js/dist/video.min.js') }}"></script>
    <script src="{{ url('components/comment-core-library/build/CommentCoreLibrary.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            var partList = document.getElementsByClassName('video_part_select');
            var cid = partList[0].getAttribute('cid');

            window.quality = '1';
            window.cid = cid;

            loadVideoJsAndPlugin();

            getMp4(window.cid, window.quality);

            $('.quality_select').on('click', function () {
                var quality = $(this).attr('quality');
                if (window.quality != quality) {
                    window.quality = quality;
                    getMp4(window.cid, window.quality);
                }
            });

            $('.video_part_select').on('click', function () {
                var cid = $(this).attr('cid');
                if (window.cid != cid) {
                    window.cid = cid;
                    getMp4(window.cid, window.quality);
                }
            });

        });

    </script>



@endsection
