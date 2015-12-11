@extends('common.layout')


@section('title', 'Nico:'.$tag_name)

@section('css')
    @parent

@endsection


@section('content')

    <div class="row">
        <div class="container">
            <div class="col-xs-2 well">
                <ul class="nav nav-pills nav-stacked">
                    @foreach(\App\Utils\BiliBiliHelper::getNicoSorts() as $sort_key=>$sort_value)
                        <li><a href="{{ url('/sortnico/'.$sort_key) }}">{{ $sort_value }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div class="col-xs-10">
                <div class="row">
                    <h3 class="wb_title_split">{{ $tag_name }}
                        <small class="wb_small">更新于 {{ $date }}</small>
                    </h3>
                    <div class="grid">

                        @foreach($list as $gird)

                            <div class="grid-item">
                                <a href="{{ url('/viewnico/'.$gird['id']) }}" target="_blank" class="thumbnail tex">
                                    <img src="http://tn-skr2.smilevideo.jp/smile?i={{ \App\Utils\BiliBiliHelper::FetchNicoId($gird['id']) }}"
                                         alt="...">

                                    <div class="caption">
                                        <p>{{ $gird['title'] }}</p>
                                    </div>
                                </a>
                            </div>

                        @endforeach

                    </div>

                </div>

                <div class="row text-center">
                    <nav>
                        <ul class="pager">

                            @if($page!=1)
                                <li class="previous">
                                    <a href="{{ url('/sortnico/'.$sort.'?page='.($page-1)) }}">
                                        <span aria-hidden="true">&larr;</span> 前一页 </a>
                                </li>
                            @endif

                            @if($page!=2)
                                <li class="next"><a href="{{ url('/sortnico/'.$sort.'?page='.($page+1)) }}"> 后一页 <span
                                                aria-hidden="true">&rarr;</span></a></li>
                            @endif
                        </ul>
                    </nav>
                </div>

            </div>
        </div>
    </div>

@endsection

@section('javascript')
    @parent
    <script src="{{ url('js/masonry.pkgd.min.js') }}"></script>
    <script src="{{ url('js/imagesloaded.pkgd.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            var $container = $('.grid');
            $container.imagesLoaded(function () {
                $container.masonry({
                    itemSelector: '.grid-item',
                    columnLength: 200
                });
            });
        });
    </script>
@endsection
