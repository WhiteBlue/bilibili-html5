@extends('pusher.layout')


@section('css')
    @parent
    <style>

    </style>
@endsection


@section('content')

    <div class="row text-center">
        <img src="{{ url('img/error.jpg') }}">

        <h3>{{ $error_content }}</h3>
    </div>

@endsection

@section('javascript')
    @parent

@endsection
