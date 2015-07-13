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
                <h3>{{ $info->title }}
                    <small>{{ $info->description }}</small>
                </h3>
            </div>
            <div class="col-md-4 text-center visible-md visible-lg">
                <h3>
                    <a href="#" class="btn btn-success next">去B站看>></a>
                </h3>
            </div>
        </div>
    </div>

    <div class="jumbotron" id="container">


        <div id="load-player" id="viewer"></div>

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
                <a href="#" class="list-group-item">Dapibus ac facilisis in</a>
                <a href="#" class="list-group-item">Morbi leo risus</a>
                <a href="#" class="list-group-item">Porta ac consectetur ac</a>
                <a href="#" class="list-group-item">Vestibulum at eros</a>
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
            window.addEventListener("load", function () {

                function launchHtml5() {
                    ABP.create(document.getElementById("load-player"), {
                        "src": {
                            "playlist": [
                                {
                                    "video": document.getElementById("video-1"),
                                    "comments": "comment-otsukimi.xml"
                                }
                            ]
                        },
                        "width": $('#viewer').offsetWidth,
                        "height": 522
                    });
                }

                alert('获取开始');
                /**
                 * 获取视频地址
                 */
                $.get("{{ url('/play/2553270-1') }}", function (data, status) {
                    if (data == false) {
                        alert("请重新载入");
                    }
                    if (data == 1) {
                        $('#viewer').append("<object width=" + $('#viewer').offsetWidth + " height='522'><param value='{{ $info->offsite }}' name='movie'>" +
                                "</object>");
                    } else {
                        $('#container').append("<video id='video-1' autobuffer='true' data-setup='{}' width='800' height='450'>"
                                + "<source src='" + data['durl'][0]['url'] + "' type='video/mp4'>" +
                                "<p>Your browser does not support html5 video!</p>" +
                                "</video>");
                        launchHtml5();
                    }
                });
            });


        });
    </script>
@endsection