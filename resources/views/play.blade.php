@extends('common.layout')


@section('css')
    @parent
    <link rel="stylesheet" href="{{ url('/components/video.js/dist/video-js.min.css') }}">
    <link rel="stylesheet" href="{{ url('/styles/player.css') }}">
    <style>
        @keyframes cmt-move-left {
            100% {
                right: 100%;
            }
        }

        @keyframes cmt-move-right {
            100% {
                left: 100%;
            }
        }
    </style>
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

            loadVideoJsPlugin();

            renderVideo({{$aid}});
        });
    </script>
@endsection
