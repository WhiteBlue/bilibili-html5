@extends('common.layout')

@section('title', '搜索:'.urldecode($search))

@section('css')
    @parent

@endsection


@section('content')

    <ol class="breadcrumb">
        <li class="active">搜索：{{ urldecode($search) }}</li>
    </ol>

    <div class="well" style="padding: 20px">
        <div class="row" id="search_result" style="padding: 20px">

            @foreach($back['result'] as $li)
                @if($li['type']=='special')
                    <div class="col-md-6">
                        <div class="panel panel-default wb_panel">
                            <div class="panel-heading"><h3 class="panel-title">{{ $li['title'] }}</h3>
                            </div>
                            <div class="panel-body">
                                <div class="col-xs-6 text-center"><img class="wb_seach_img" src="{{ $li['pic'] }}"
                                                                       alt="{{ $li['title'] }}">
                                </div>
                                <div class="col-xs-6">
                                    <div class="well wb_seach_brief">{{ $li['description'] }}</div>
                                    <a href="#" class="btn btn-large btn-block btn-primary">查看</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-md-3">
                        <a href="{{ url('/view/'.$li['aid']) }}" class="thumbnail wb_thumbnail">
                            <img src="{{ $li['pic'] }}" alt="{{ $li['title'] }}" style="height: 100px">

                            <div class="caption">
                                <p>{{ $li['title'] }}</p>
                                <span class="label label-info bottom">{{ $li['typename'] }}</span>
                            </div>
                        </a>
                    </div>
                @endif

            @endforeach

        </div>

        <div class="row text-center">
            <a class="btn btn-info next" href="javascript:void(0)" id="load_btn" style="display: none">>加载更多<</a>
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
                                                $('#search_result').append("<div class='col-md-6'>" +
                                                        "<div class='panel panel-default wb_panel'><div class='panel-heading'><h3 class='panel-title'>" + li.title + "</h3>" +
                                                        "</div><div class='panel-body'><div class='col-xs-6 text-center'><img class='wb_seach_img' src='" + li.pic + "' alt='" + li.title + "'>" +
                                                        "</div><div class='col-xs-6'><div class='well wb_seach_brief'>" + li.description + "</div><a href='#' class='btn btn-large btn-block btn-primary'>查看</a>" +
                                                        "</div></div></div></div>");
                                            } else {
                                                $('#search_result').append("<div class='col-md-3'><a href='{{ url('/view/') }}" + li.aid + "' class='thumbnail wb_thumbnail'><img src='" + li.pic + "' alt='" + li.title + "' style='height: 100px'>" +
                                                        "<div class='caption'><p>" + li.title + "</p><span class='label label-info bottom'>" + li.typename + "</span></div></a></div>");
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
