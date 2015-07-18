@extends('pusher.layout')

@section('css')
    @parent
    <link rel="stylesheet" href="{{ url('ABplayer/css/base.min.css?1') }}"/>
    <script src="{{ url('ABplayer/js/CommentCoreLibrary.min.js') }}"></script>
    <script src="{{ url('ABplayer/js/ABPlayer.min.js') }}"></script>
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

    <div class="jumbotron text-center">



        <div id='load-player'>
        </div>

        <div id="viewer">
        </div>


        <div class="row text-center" id="chooser">
            <nav>
                <ul class="pager">
                    <li class=""><a href="#" id="cho-danku"> H5播放器 </a></li>
                    <li class="next"><a href="#" id="cho-flash"> Flash播放器 </a></li>
                </ul>
            </nav>
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
        $(document).ready(function () {
            var $_ = function (e) {
                return document.getElementById(e);
            };

            var player_width = parseInt($('#container').css('width'));

            function launch_flash() {
                $('#viewer').append("<object width='90%' height='550px'><param value='{{ $info->offsite }}' name='movie'>" +
                        "</object>");
            }

            function launch_h5() {
                $.get("{{ url('/play/'.$info->cid.'-1') }}", function (data, status) {
                    if (!data) {
                        launch_flash();
                    } else {
                        $('#viewer').append("<video class='video-js' preload='auto' poster='assets/img/video/poster.jpg' data-setup='{}'>" +
                                "<source src='" + data['url'] + "' type='video/mp4'>" +
                                "<p> = = 少年该换浏览器了~</p>" +
                                "</video>");
                    }
                });

            }

            function launch_danku() {
                $.get("{{ url('/play/'.$info->cid.'-1') }}", function (data, status) {
                    if (!data) {
                        launch_flash();
                    } else {
                        $('#viewer').append("<video id='video-danku' autobuffer='true' data-setup='{}' poster='{{ $info->pic }}'>" +
                                "<source src='" + data['url'] + "' type='video/mp4'><p> = = 少年该换浏览器了~</p></video>");
                        ABP.create(document.getElementById('load-player'), {
                            "src": {
                                "playlist": [
                                    {
                                        "video": document.getElementById('video-danku'),
                                        "comments": "http://comment.bilibili.cn/{{ $info->cid }}.xml"
                                    }
                                ]
                            },
                            "width": player_width * 0.85,
                            "height": 522
                        });
                    }
                });
            }


            $('#cho-h5').click(function () {
                launch_h5();
                $('#chooser').hide();
            });

            $('#cho-danku').click(function () {
                launch_danku();

                $('#chooser').hide();
            });

            $('#cho-flash').click(function () {
                launch_flash();
                $('#chooser').hide();
            });
        });
    </script>
@endsection