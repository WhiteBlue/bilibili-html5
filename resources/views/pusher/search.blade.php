@extends('pusher.layout')

@section('css')
    @parent
@endsection

@section('content')
    <ol class="breadcrumb">
        <li class="active">搜索：{{ $search }}</li>
    </ol>

    <div class="well">
        <div class="row" id="search_result">
            @foreach($back->result as $li)
                @if($li->type=='special')
                    <div class="col-md-6 bili-sp">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">{{ $li->typename."-".$li->title }}</h3>
                            </div>
                            <div class="panel-body">
                                <div class="col-xs-6">
                                    <img style="width: 100%"
                                         src="{{ $li->pic }}"
                                         alt="...">
                                </div>
                                <div class="col-xs-6">
                                    <div class="well bili-sp-content">
                                        <small>{{ $li->description }}</small>
                                    </div>
                                    <a href="#" class="btn btn-large btn-block btn-primary">查看</a>
                                </div>
                            </div>

                        </div>
                    </div>
                @else
                    <div class="col-md-3">
                        <a href="#" class="thumbnail tex bili-search-a">
                            <img src="{{ $li->pic }}" alt="..." style="width: 100%;height:130px;">

                            <div class="caption bili-search-caption">
                                <p class="bili-search-content">{{ $li->title }}</p>
                                <span class="label label-default bottom">{{ $li->typename }}</span>
                            </div>
                        </a>
                    </div>
                @endif

            @endforeach


        </div>


    </div>
@endsection

@section('javascript')
    @parent

    <script>
        $(document).ready(function () {
            time = 1;
            all ={{ $back->page }};

            function load_new() {
                if (time > 2 && time < all) {
                    $.get("{{ url('/searchPage/'.$search.'?page=') }}" + time,
                            function (data, status) {
                                $.each(data.result, function (key, li) {
                                    if (li.type == 'special') {
                                        $('#search_result').append("<div class='col-md-6 bili-sp new' style='display: none'><div class='panel panel-default'>" +
                                                "<div class='panel-heading'><h3 class='panel-title'>" + li.typename + "-" + li.title + "</h3></div>" +
                                                "<div class='panel-body'><div class='col-xs-6'><img style='width: 100%' src='" + li.pic + "' alt='...'> </div><div class='col-xs-6'>" +
                                                "<div class='well bili-sp-content'><small>" + li.description + "</small></div> <a href='#' class='btn btn-large btn-block btn-primary'>查看</a>" +
                                                "</div></div></div></div>");
                                    } else {
                                        $('#search_result').append("<div class='col-md-3 new' style='display: none'>" +
                                                "<a href='#' class='thumbnail tex bili-search-a'><img style='width: auto;height:130px;' src='" + li.pic + "'alt='...'>" +
                                                "<div class='caption bili-search-caption'><p class='bili-search-content'>" + li.title + "</p><span class='label label-default bottom'>" + li.typename + "</span>" +
                                                "</div></a></div>");
                                    }

                                    $(".new").fadeIn("slow");
                                });
                            });
                }
            }

            $(window).bind("scroll", function () {
                if ($(document).scrollTop() + $(window).height() > $(document).height() - 10) {
                    load_new();
                    time++;
                }
            });
        });
    </script>

@endsection