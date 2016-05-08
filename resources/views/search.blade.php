@extends('common.layout')

@section('css')
    @parent
@endsection

@section('content')
    <div id="main-container" class="concat"></div>
@endsection

@section('javascript')
    @parent
    <script type="text/javascript">
        $(document).ready(function () {
            $('.needstick').stickUp({});

            renderSearch('{{$keyword}}');
        });
    </script>
@endsection
