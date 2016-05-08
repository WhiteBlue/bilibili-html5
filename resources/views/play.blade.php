@extends('common.layout')


@section('css')
    @parent
    <link rel="stylesheet" href="{{ url('/components/video.js/dist/video-js.min.css') }}">
    <link rel="stylesheet" href="{{ url('/styles/player.css') }}">
@endsection


@section('content')
    <div id="main-container" class="concat"></div>
@endsection


@section('javascript')
    @parent
    <script type="text/javascript" src="{{ url('/components/video.js/dist/video.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('/js/comment-library.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('/js/player.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.needstick').stickUp({});

            loadVideoJsPlugin();

            renderVideo({{$aid}});
        });
    </script>
@endsection
