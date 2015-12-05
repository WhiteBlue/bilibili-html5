@extends('common.layout')

@section('title', '首页')

@section('css')
    @parent

@endsection


@section('content')
    <div class="jumbotron wb-jumbotron bili-logo">
        <h1 style="color:whitesmoke">BiliBili Html5</h1>
        <p class="lead">视频源替换，纯Html5播放器，根治macbook发热</p>
    </div>
    @foreach($sorts as $tid=>$name)
        <h3 class="wb_title_split">{{ $name }}
            <small class="wb_small">更新于 {{ $update_time }}</small>
        </h3>
        <div class="row wb_line_row">
            <div class="wb_container_left">
                <a href="{{ url('/view/'.$list[$name][0]['aid']) }}" target="_blank"
                   class="thumbnail wb_thumbnail_big">
                    <img src="{{ $list[$name][0]['pic'] }}" alt="{{ $list[$name][0]['title'] }}"
                         style="height:170px">
                    <div class="caption">
                        <p class="title text-center">{{ $list[$name][0]['title'] }}</p>
                        <p class="intro">{{ $list[$name][0]['description'] }}</p>
                    </div>
                </a>
            </div>
            <div class="wb_container_right">
                @for($i=1;$i<sizeof($list[$name]);$i++)
                    <div class="col-md-3">
                        <a class="wb-show" href="{{ url('/view/'.$list[$name][$i]['aid']) }}" target="_blank">
                            <div class="wb-show-shadow">
                                <p class="wb-show-intro">{{ $list[$name][$i]['description'] }}</p>

                                <p class="wb-show-play">播放: {{ $list[$name][$i]['play'] }}
                                    &nbsp;&nbsp;&nbsp;&nbsp;弹幕: {{ $list[$name][$i]['comment'] }}</p>
                            </div>
                            <img src="{{ $list[$name][$i]['pic'] }}"
                                 alt="{{ $list[$name][$i]['title'] }}">
                            <div class="caption">
                                <p>{{ $list[$name][$i]['title'] }}</p>
                            </div>
                        </a>
                    </div>
                @endfor
            </div>

        </div>
    @endforeach

@endsection

@section('javascript')
    @parent

@endsection
