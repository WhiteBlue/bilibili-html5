@extends('common.layout')

@section('title', '搜索:'.urldecode($search))

@section('css')
    @parent

@endsection


@section('content')

    <ol class="breadcrumb">
        <li class="active">搜索：{{ urldecode($search) }}</li>
    </ol>

    <div class="row well">

        @foreach($back['result'] as $li)
            @if($li['type']=='special')
                <div class="col-md-6">
                    <a href="{{ url('/sp/'.$li['title']) }}" target="_blank" class="thumbnail sp_thumbnail">
                        <img src="{{ $li['pic'] }}" alt="{{ $li['title'] }}">

                        <div class="right_content">
                            <h4>专题:{{ $li['title'] }}</h4>

                            <p>{{ $li['description'] }}</p>
                        </div>
                    </a>
                </div>
            @else
                <div class="col-md-3">
                    <a class="wb-show wb-show_middle" href="{{ url('/view/'.$li['aid']) }}" target="_blank">
                        <div class="wb-show-shadow wb-show-shadow_middle">
                            <p class="wb-show-intro">{{ $li['description'] }}</p>
                            <p class="wb-show-play">播放:{{ $li['play'] }}
                                &nbsp;&nbsp;&nbsp;&nbsp;{{ $li['typename'] }}</p>
                        </div>
                        <img src="{{ $li['pic'] }}" alt="{{ $li['title'] }}" style="max-height: 120px">
                        <div class="caption text-center">
                            <p>{{ $li['title'] }}</p>
                        </div>
                    </a>
                </div>
            @endif
        @endforeach

    </div>

    <div class="row text-center">
        <nav>
            <ul class="pager">

                @if($page!=1)
                    <li class="previous">
                        <a href="{{ url('/search?keyword='.$search.'&page='.($page-1)) }}">
                            <span aria-hidden="true">&larr;</span> 前一页 </a>
                    </li>
                @endif
                <li class="next"><a href="{{ url('/search?keyword='.$search.'&page='.($page+1)) }}"> 后一页 <span
                                aria-hidden="true">&rarr;</span></a></li>

            </ul>
        </nav>
    </div>

@endsection

@section('javascript')
    @parent

@endsection
