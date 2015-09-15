@extends('pusher.layout')


@section('css')
    @parent

@endsection


@section('content')

    <div class="jumbotron wb-jumbotron bili-logo">
        <h1 style="color: whitesmoke">BiliBili Html5</h1>

        <p class="lead">全浏览器支持，破解会员限制，目标=>流畅，两种播放器可选</p>

        <div class="input-group input-group-hg input-group-rounded bili-search">
            <span class="input-group-btn">
                <button id="search-submit" class="btn"><span class="fui-search"></span></button>
            </span>
            <input type="text" id="search-content" class="form-control" placeholder="这里搜索" id="search-query-2">
        </div>

    </div>


    @foreach ($list as $li)
        <blockquote>
            <h2>{{ $li['sort']->title }}</h2>
            <footer><cite title="Source Title">{{ $li['sort']->content }}</cite> 更新于: {{ $time }}
            </footer>
        </blockquote>
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row wb-row">
                    @foreach( $li['list'] as $save)

                        <a class="wb-show" href="{{ url('/view/'.$save['aid']) }}" target="_blank">
                            <div class="wb-show-shadow">
                                <p class="wb-show-intro">{{ $save['description'] }}</p>

                                <p class="wb-show-play">播放:{{ $save['play'] }} 弹幕:{{ $save['comment'] }}</p>
                            </div>

                            <img src="{{ $save['pic'] }}" alt="icon_pic">

                            <div class="caption">
                                <p>{{ $save['title'] }}</p>
                            </div>
                        </a>

                    @endforeach

                </div>
            </div>
        </div>

    @endforeach


@endsection

@section('javascript')
    @parent

    <script type="text/javascript" src="{{ url('js/index.js') }}"></script>
    <script type="text/javascript">
        $('#search-submit').click(function () {
            if ($('#search-content').val().length > 0)
                window.location = '{{ url('/search') }}/' + encodeURIComponent($('#search-content').val());
        });

        $('.wb-jumbotron').bind('keyup', function (event) {
            if (event.keyCode == "13") {
                //回车执行查询
                window.location = '{{ url('/search') }}/' + encodeURIComponent($('#search-content').val());
            }
        });
    </script>
@endsection
