@extends('pusher.layout')

@section('css')
    @parent
    <style>
        .today-new {
            height: 100px;
        }

        .all-new {
            height: 111px;
            overflow: hidden;
        }
    </style>
@endsection

@section('content')

    <div class="page-header">
        <h1>新番列表
            <small>同步自BiliBili</small>
        </h1>
    </div>


    <blockquote>
        <h2>今日更新</h2>
        <footer><cite title="Source Title">更新时间 : {{ $time }}</cite></footer>
    </blockquote>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                @foreach($list[$weekday] as $each)

                    <div class="col-sm-6">
                        <a href="http://www.bilibili.com/sp/{{ $each['title'] }}" class="thumbnail"
                           style="margin: 10px">
                            <div class="row">
                                <div class="col-sm-5">
                                    <img src="{{ $each['mcover'] }}" alt="...">

                                </div>
                                <div class="col-sm-7">
                                    <div class="caption today-new">
                                        <p class="tile-title text-center">{{ $each['title'] }}</p>
                                    </div>

                                    <div class="caption text-center">
                                        <p>最新 : 第 {{ $each['bgmcount'] }} 集
                                            @if($each['new'])
                                                <span class="label label-info">有更新</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                @endforeach
            </div>
        </div>
    </div>

    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        <div class="panel panel-default" id="day1">
            <div class="panel-heading" role="tab" id="headingOne">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne"
                       aria-expanded="true" aria-controls="collapseOne">
                        周一
                    </a>
                </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body">
                    <blockquote>
                        <h4>周一更新</h4>
                    </blockquote>

                    <div class="row">

                        @foreach($list[1] as $each)
                            <div class="col-sm-6 col-md-2">
                                <a href="http://www.bilibili.com/sp/{{ $each['title'] }}" class="thumbnail"
                                   style="margin: 10px">
                                    <img src="{{ $each['mcover'] }}"
                                         alt="...">

                                    <div class="caption text-center all-new">
                                        <small>{{ $each['title'] }} - {{ $each['bgmcount'] }}</small>
                                    </div>
                                </a>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default" id="day2">
            <div class="panel-heading" role="tab" id="headingTwo">
                <h4 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                       href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        周二
                    </a>
                </h4>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                <div class="panel-body">
                    <blockquote>
                        <h4>周二更新</h4>
                    </blockquote>

                    <div class="row">

                        @foreach($list[2] as $each)
                            <div class="col-sm-6 col-md-2">
                                <a href="http://www.bilibili.com/sp/{{ $each['title'] }}" class="thumbnail"
                                   style="margin: 10px">
                                    <img src="{{ $each['mcover'] }}"
                                         alt="...">

                                    <div class="caption text-center all-new">
                                        <small>{{ $each['title'] }} - {{ $each['bgmcount'] }}</small>
                                    </div>
                                </a>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default" id="day3">
            <div class="panel-heading" role="tab" id="headingThree">
                <h4 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                       href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        周三
                    </a>
                </h4>
            </div>
            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                <div class="panel-body">
                    <blockquote>
                        <h4>周三更新</h4>
                    </blockquote>

                    <div class="row">

                        @foreach($list[3] as $each)
                            <div class="col-sm-6 col-md-2">
                                <a href="http://www.bilibili.com/sp/{{ $each['title'] }}" class="thumbnail"
                                   style="margin: 10px">
                                    <img src="{{ $each['mcover'] }}"
                                         alt="...">

                                    <div class="caption text-center all-new">
                                        <small>{{ $each['title'] }} - {{ $each['bgmcount'] }}</small>
                                    </div>
                                </a>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-default" id="day4">
            <div class="panel-heading" role="tab" id="headingFour">
                <h4 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                       href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                        周四
                    </a>
                </h4>
            </div>
            <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapseFour">
                <div class="panel-body">
                    <blockquote>
                        <h4>周四更新</h4>
                    </blockquote>

                    <div class="row">

                        @foreach($list[4] as $each)
                            <div class="col-sm-6 col-md-2">
                                <a href="http://www.bilibili.com/sp/{{ $each['title'] }}" class="thumbnail"
                                   style="margin: 10px">
                                    <img src="{{ $each['mcover'] }}"
                                         alt="...">

                                    <div class="caption text-center all-new">
                                        <small>{{ $each['title'] }} - {{ $each['bgmcount'] }}</small>
                                    </div>
                                </a>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-default" id="day5">
            <div class="panel-heading" role="tab" id="headingFive">
                <h4 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                       href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                        周五
                    </a>
                </h4>
            </div>
            <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapseFive">
                <div class="panel-body">
                    <blockquote>
                        <h4>周五更新</h4>
                    </blockquote>

                    <div class="row">

                        @foreach($list[5] as $each)
                            <div class="col-sm-6 col-md-2">
                                <a href="http://www.bilibili.com/sp/{{ $each['title'] }}" class="thumbnail"
                                   style="margin: 10px">
                                    <img src="{{ $each['mcover'] }}"
                                         alt="...">

                                    <div class="caption text-center all-new">
                                        <small>{{ $each['title'] }} - {{ $each['bgmcount'] }}</small>
                                    </div>
                                </a>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-default" id="day6">
            <div class="panel-heading" role="tab" id="headingSix">
                <h4 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                       href="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                        周六
                    </a>
                </h4>
            </div>
            <div id="collapseSix" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapseSix">
                <div class="panel-body">
                    <blockquote>
                        <h4>周六更新</h4>
                    </blockquote>

                    <div class="row">

                        @foreach($list[6] as $each)
                            <div class="col-sm-6 col-md-2">
                                <a href="http://www.bilibili.com/sp/{{ $each['title'] }}" class="thumbnail"
                                   style="margin: 10px">
                                    <img src="{{ $each['mcover'] }}"
                                         alt="...">

                                    <div class="caption text-center all-new">
                                        <small>{{ $each['title'] }} - {{ $each['bgmcount'] }}</small>
                                    </div>
                                </a>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-default" id="day0">
            <div class="panel-heading" role="tab" id="headingSeven">
                <h4 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                       href="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                        周日
                    </a>
                </h4>
            </div>
            <div id="collapseSeven" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapseFive">
                <div class="panel-body">
                    <blockquote>
                        <h4>周日更新</h4>
                    </blockquote>

                    <div class="row">

                        @foreach($list[0] as $each)
                            <div class="col-sm-6 col-md-2">
                                <a href="http://www.bilibili.com/sp/{{ $each['title'] }}" class="thumbnail"
                                   style="margin: 10px">
                                    <img src="{{ $each['mcover'] }}"
                                         alt="...">

                                    <div class="caption text-center all-new">
                                        <small>{{ $each['title'] }} - {{ $each['bgmcount'] }}</small>
                                    </div>
                                </a>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('javascript')
    @parent

    <script>
        $(document).ready(function () {
            var date = new Date();
            $('#day' + date.getDay()).hide();
        });
    </script>

@endsection