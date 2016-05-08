@extends('common.layout')


@section('css')
    @parent
@endsection

@section('content')
    <div id="main-container"></div>
@endsection

@section('javascript')
    @parent
    <script>
        $(document).ready(function () {
            $('.needstick').stickUp({});

            renderSort({{ $tid }});
        });
    </script>
@endsection
