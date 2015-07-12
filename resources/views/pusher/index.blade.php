@extends('pusher.layout')

@section('content')

    <div class="jumbotron">
        <h1>BiliBili Pusher</h1>

        <p class="lead">关注喜欢的Up主，一旦有更新，我们会第一时间邮件通知。</p>

        <p><a class="btn btn-lg btn-success" href="#" role="button">加入我们</a></p>
    </div>


    @foreach ($list as $li)
        <blockquote>
            <h2>{{ $li['sort']->title }}</h2>
            <footer><cite title="Source Title">{{ $li['sort']->content }}</cite>  更新于: {{ $li['sort']->updated_at }}</footer>
        </blockquote>
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    @foreach( $li['list'] as $save)

                        <div class="col-sm-6 col-md-3">
                            <div class="thumbnail">
                                <img class="minImg" style="height: 100px;" src="{{ $save->img }}">

                                <div class="caption">
                                    <h4 class="tile-title">{{ $save->title }}</h4>

                                    <p class="biliContent">{{ $save->content }}</p>
                                </div>
                                <p><a class="btn btn-primary btn-large btn-block" href="{{ $save->href }}">立即观看</a>
                                </p>
                            </div>
                        </div>

                    @endforeach

                </div>
            </div>
        </div>

    @endforeach


@endsection