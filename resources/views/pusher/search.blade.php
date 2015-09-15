@extends('pusher.layout')

@section('css')
    @parent
@endsection

@section('content')
    <ol class="breadcrumb">
        <li class="active">搜索：{{ urldecode($search) }}</li>
    </ol>

    <div class="well">
        <div class="row" id="search_result">
            @foreach($back['result'] as $li)
                @if($li['type']=='special')
                    <div class="col-md-6 bili-sp">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">{{ $li['typename']."-".$li['title'] }}</h3>
                            </div>
                            <div class="panel-body">
                                <div class="col-xs-6">
                                    <img class="search_img"
                                         src="{{ $li['pic'] }}"
                                         alt="...">
                                </div>
                                <div class="col-xs-6">
                                    <div class="well bili-sp-content">
                                        <small>{{ $li['description'] }}</small>
                                    </div>
                                    <a href="http://www.bilibili.com/sp/{{ $li['title'] }}"
                                       class="btn btn-large btn-block btn-primary">查看</a>
                                </div>
                            </div>

                        </div>
                    </div>
                @else
                    <div class="col-md-3">
                        <a href="{{ url('/view/'.$li['aid']) }}" class="thumbnail tex bili-search-a" target="_blank">
                            <img src="{{ $li['pic'] }}" alt="..." style="width: 100%;height:130px;">

                            <div class="caption bili-search-caption">
                                <p class="bili-search-content">{{ $li['title'] }}</p>
                                <span class="label label-default bottom">{{ $li['typename'] }}</span>
                            </div>
                        </a>
                    </div>
                @endif

            @endforeach


        </div>

        <div class="row text-center">
            <a class="btn btn-info next" id="load_btn" style="display: none">>加载更多<</a>
        </div>
    </div>
@endsection

@section('javascript')
    @parent

    <script>
        $(document).ready(function () {
            time = 1;
            page = 2;
            flag = true;
            lock = true;

            function load_new() {
                if (time > 1) {
                    if (time > 5) {
                        $('#load_btn').fadeIn();
                        flag = false;
                    } else {
                        $.get("{{ url('/searchPage/'.$search.'?page=') }}" + page,
                                function (data, status) {
                                    if (data.code == 'success') {
                                        if (data.content.result.length == 0) {
                                            lock = false;
                                        }
                                        $.each(data.content.result, function (key, li) {
                                            if (li.type == 'special') {
                                                $('#search_result').append("<div class='col-md-6 bili-sp new' style='display: none'><div class='panel panel-default'>" +
                                                        "<div class='panel-heading'><h3 class='panel-title'>" + li.typename + "-" + li.title + "</h3></div>" +
                                                        "<div class='panel-body'><div class='col-xs-6'><img class='search_img' src='" + li.pic + "' alt='...'> </div><div class='col-xs-6'>" +
                                                        "<div class='well bili-sp-content'><small>" + li.description + "</small></div> <a href='#' class='btn btn-large btn-block btn-primary'>查看</a>" +
                                                        "</div></div></div></div>");
                                            } else {
                                                $('#search_result').append("<div class='col-md-3 new' style='display: none'>" +
                                                        "<a href='{{ url('/view/') }}" + li.aid + "' target='_blank' class='thumbnail tex bili-search-a'><img style='width: auto;height:130px;' src='" + li.pic + "'alt='...'>" +
                                                        "<div class='caption bili-search-caption'><p class='bili-search-content'>" + li.title + "</p><span class='label label-default bottom'>" + li.typename + "</span>" +
                                                        "</div></a></div>");
                                            }

                                            $(".new").fadeIn("slow");
                                        });
                                        page++;
                                    } else {
                                        alert('error');
                                    }
                                });
                    }
                }
            }

            $('#load_btn').click(function () {
                flag = true;
                time = 0;
                $(this).fadeOut();
            });

            $(window).bind("scroll", function () {
                if ($(document).scrollTop() + $(window).height() > $(document).height() - 10) {
                    if (lock && flag) {
                        load_new();
                        time++;
                    }
                }
            });
        });
    </script>

@endsection