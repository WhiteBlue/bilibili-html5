@extends('common.layout')


@section('title', $content['title'])

@section('css')
    @parent

    <style>
        .nico_video {
            width: 900px;
            height: 600px;
            margin: 30px auto;
        }
    </style>

@endsection


@section('content')

    <div class="panel panel-default">
        <div class="panel-body text-center">
            <h3>{{ $content['title'] }}</h3>

            <p>播放: {{ $content['view_counter'] }} 收藏: {{ $content['mylist_counter'] }}</p>
        </div>
    </div>


    <div class="well wb_video_content">

        <div class="nico_video">
            <script type="text/javascript"
                    src="http://ext.nicovideo.jp/thumb_watch/{{ $content['id'] }}?w=900&h=600&n=1"></script>
        </div>

    </div>

    <div class="row">

        <div class="col-sm-3">
            <div class="thumbnail text-center" style="height: 300px">
                <img src="{{ $content['thumbnail_url'] }}" alt="...">

            </div>
        </div>
        <div class="col-sm-9">
            <div class="panel panel-default wb_video_brief" style="">
                <div class="panel-body text-center">
                    <div class="media">
                        <div class="media-body">
                            <h4 class="media-heading">简介</h4>

                            <p class="wb_video_brief_p">
                                {{ $content['description'] }}
                            </p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('javascript')
    @parent

@endsection
