@extends('common.layout')


@section('title', '分类:'.$content['name'])

@section('css')
    @parent

@endsection


@section('content')

    <div class="row">
        <div class="container">
            <div class="col-md-2 well">
                <ul class="nav nav-pills nav-stacked">
                    @foreach(\App\Utils\BiliBiliHelper::$sorts as $sort_key=>$sort_value)
                        <li><a href="{{ url('/sort/'.$sort_key) }}">{{ $sort_value }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div class="col-md-10">
                <nav>
                    <ul class="pager">
                        <li class="previous"><a href="{{ url('/sort/'.$tid.'?page='.$page.'&order=hot') }}">最热</a></li>
                        <li class="next"><a href="{{ url('/sort/'.$tid.'?page='.$page.'&order=new') }}">最新</a></li>
                    </ul>
                </nav>
                <div class="row">
                    <h3 class="wb_title_split">{{ $content['name'] }}
                        <small class="wb_small">更新于 {{ $date }}</small>
                    </h3>
                    <div class="grid">
                        @foreach($content['list'] as $video)
                            <div class="col-md-3">
                                <a class="wb-show wb-show_middle" href="{{ url('/view/'.$video['aid']) }}"
                                   target="_blank">
                                    <div class="wb-show-shadow wb-show-shadow_middle">
                                        <p class="wb-show-intro">{{ $video['description'] }}</p>

                                        <p class="wb-show-play">播放: {{ $video['play'] }}
                                            弹幕: {{$video['video_review'] }}</p>
                                    </div>
                                    <img src="{{ $video['pic'] }}" alt="{{ $video['title'] }}">

                                    <div class="caption">
                                        <p>{{ $video['title'] }}</p>
                                    </div>
                                </a>
                            </div>
                        @endforeach

                    </div>

                </div>

                <div class="row text-center">
                    <nav>
                        <ul class="pager">

                            @if($page!=1)
                                <li class="previous">
                                    <a href="{{ url('/sort/'.$tid.'?page='.($page-1).'&order='.$order) }}">
                                        <span aria-hidden="true">&larr;</span> 前一页 </a>
                                </li>
                            @endif

                            <li class="next"><a href="{{ url('/sort/'.$tid.'?page='.($page+1).'&order='.$order) }}"> 后一页 <span
                                            aria-hidden="true">&rarr;</span></a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('javascript')
    @parent

@endsection
