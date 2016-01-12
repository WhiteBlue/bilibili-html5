@extends('common.layout')

@section('title', '搜索:'.urldecode($keyword))

@section('css')
    @parent

@endsection


@section('content')

    <ol class="breadcrumb">
        <li class="active">搜索：{{ urldecode($keyword) }}</li>
    </ol>

    <ul class="nav nav-tabs">
        <li role="presentation" class="search-tab" id="tab_video" tab-type="video">
            <a href="javascript:void(0)">视频</a>
        </li>
        <li role="presentation" class="search-tab" id="tab_bangumi" tab-type="bangumi">
            <a href="javascript:void(0)">番剧</a>
        </li>
        <li role="presentation" class="search-tab" id="tab_topic" tab-type="topic">
            <a href="javascript:void(0)">专题</a>
        </li>
        <li role="presentation" class="search-tab" id="tab_upuser" tab-type="upuser">
            <a href="javascript:void(0)">Up主</a>
        </li>
    </ul>

    <div class="container">
        @if($type=='upuser')
            @foreach($content['result'] as $user)
                <div class="col-md-2">
                    <a href="#" class="thumbnail upuser-thumb">
                        <img src="{{ $user['upic'] }}" alt="{{ $user['uname'] }}">

                        <div class="caption text-center">
                            <p>{{ $user['uname'] }}</p>
                        </div>
                    </a>
                </div>
            @endforeach
        @elseif($type=='topic'||$type=='bangumi')
            @foreach($content['result'] as $sp)
                <div class="col-md-6">
                    <a href="{{ url('sp/'.$sp['spid']) }}" target="_blank" class="thumbnail sp_thumbnail">
                        <img src="{{ $sp['cover'] }}" alt="{{ $sp['title'] }}">

                        <div class="right_content">
                            <h4>{{ $sp['title'] }}</h4>

                            @if($type=='topic')
                                <p>{{ $sp['description'] }}</p>
                            @else
                                <p>{{ $sp['evaluate'] }}</p>
                            @endif
                        </div>
                    </a>
                </div>
            @endforeach
        @else
            @foreach($content['result'] as $video)
                <div class="col-md-3">
                    <a class="wb-show wb-show_middle" href="{{ url('/view/'.$video['aid']) }}" target="_blank">
                        <div class="wb-show-shadow wb-show-shadow_middle">
                            <p class="wb-show-intro">{{ $video['description'] }}</p>

                            <p class="wb-show-play">播放: {{ $video['play'] }} 弹幕: {{$video['video_review'] }}</p>
                        </div>
                        <img src="{{ $video['pic'] }}" alt="{{ $video['title'] }}">

                        <div class="caption">
                            <p>{{ $video['title'] }}</p>
                        </div>
                    </a>
                </div>
            @endforeach
        @endif
    </div>

    <div class="row text-center">
        <nav>
            <ul class="pager">
                @if($page!=1)
                    <li>
                        <a onclick="pageChange({{$page-1}})" href="javascript:void(0)"><span
                                    aria-hidden="true">&larr;</span> 前一页 </a>
                    </li>
                @endif
                <li>
                    <a onclick="pageChange({{$page+1}})" href="javascript:void(0)"> 后一页 <span
                                aria-hidden="true">&rarr;</span></a>
                </li>
            </ul>
        </nav>
    </div>



@endsection

@section('javascript')
    @parent
    <script>
        $(document).ready(function () {
            $('.search-tab').bind('click', function () {
                var type = this.getAttribute('tab-type');
                var url = changeURLParam(window.location.href, 'page', 1);
                window.location = changeURLParam(url, 'type', type);
            });
            var type = getUrlParam(window.location.href, 'type');
            type = (!type) ? 'video' : type;
            $('#tab_' + type).addClass('active');
        });
    </script>
@endsection
