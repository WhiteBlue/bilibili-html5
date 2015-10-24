@extends('common.layout')

@section('title', '首页')

@section('css')
    @parent

@endsection


@section('content')
    <div class="jumbotron wb-jumbotron bili_logo">
        <h1 style="color: #88989f">BiliBili Html5</h1>

        <p class="bili_logo_lead">视频源替换，纯Html5播放器，根治macbook发热</p>
    </div>

    @foreach($sorts as $sort)

        <h3 class="wb_title_split">{{ $sort }}
            <small class="wb_small">更新于 {{ $update_time }}</small>
        </h3>

        <div class="row wb_line_row">
            <div class="wb_container_left">
                <div class="thumbnail wb_thumbnail">
                    <img class="wb_index_img" src="{{ $content[$sort][0]['pic'] }}"
                         alt="{{ $content[$sort][0]['title'] }}" style="height:120px">

                    <div class="caption">
                        <p class="title text-center">{{ $content[$sort][0]['title'] }}</p>

                        <div class="text-center">
                            <a href="{{ url('/view/'.$content[$sort][0]['aid']) }}" class="btn btn-primary"
                               role="button" target="_blank">观看</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wb_container_right">
                @for($i=1;$i<sizeof($content[$sort]);$i++)
                    <div class="col-md-3">
                        <a class="wb-show" href="{{ url('/view/'.$content[$sort][$i]['aid']) }}" target="_blank">
                            <div class="wb-show-shadow">
                                <p class="wb-show-intro">{{ $content[$sort][$i]['description'] }}</p>

                                <p class="wb-show-play">播放: {{ $content[$sort][$i]['play'] }}
                                    弹幕: {{ $content[$sort][$i]['comment'] }}</p>
                            </div>
                            <img src="{{ $content[$sort][$i]['pic'] }}"
                                 alt="...">

                            <div class="caption">
                                <p>{{ $content[$sort][$i]['title'] }}</p>
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
