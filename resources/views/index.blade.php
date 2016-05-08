@extends('common.layout')


@section('css')
    @parent
    <link rel="stylesheet" href="{{ url('/styles/slider.css') }}">
@endsection

@section('content')
    <div id="main-container"></div>
@endsection


@section('javascript')
    @parent
    <script type="text/javascript" src="{{ url('/js/slider.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.needstick').stickUp({});

            renderIndex();
        });
    </script>
@endsection
