@extends('common.layout')


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
            <small class="wb_small">更新于 2011.12.3</small>
        </h3>

        <div class="row wb_line_row">
            <div class="wb_container_left">
                <div class="thumbnail wb_thumbnail">
                    <img src="{{ $content[$sort][0]['pic'] }}" alt="{{ $content[$sort][0]['title'] }}">

                    <div class="caption">
                        <p class=title>{{ $content[$sort][0]['title'] }}</p>

                        <p class="text-center">
                            <a href="#" class="btn btn-primary" role="button">观看</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="wb_container_right">
                @for($i=1;$i<sizeof($content[$sort]);$i++)
                    <div class="col-md-3">
                        <a class="wb-show" href="#" target="_blank">
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
