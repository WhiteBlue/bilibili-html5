@extends('pusher.layout')


@section('css')
    @parent
    <style>
        .caption {
            height: 120px;
            text-overflow: ellipsis;
        }

    </style>
@endsection


@section('content')

    <div class="jumbotron bili-logo">
        <h1>BiliBili Html5</h1>

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
                <div class="row">
                    @foreach( $li['list'] as $save)

                        <div class="col-sm-6 col-md-3">
                            <a href="{{ url('/view/'.$save->aid) }}" target="_blank" class="thumbnail bili-tile">
                                <img class="minImg" style="height: 100px;" src="{{ $save->pic }}">

                                <div class="caption">
                                    <b class="tile-title" style="font-size: 90%">{{ $save->title }}</b>

                                </div>
                            </a>
                        </div>

                    @endforeach

                </div>
            </div>
        </div>

    @endforeach


@endsection

@section('javascript')
    @parent
    <script>
        $('#search-submit').click(function () {
            if ($('#search-content').val().length > 3)
                window.location = '{{ url('/search') }}/' + encodeURIComponent($('#search-content').val());
        });
    </script>
@endsection
