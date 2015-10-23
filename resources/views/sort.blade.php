@extends('common.layout')


@section('css')
    @parent

@endsection


@section('content')

    <div class="row">
        <div class="container">
            <div class="col-xs-2 well">
                <ul class="nav nav-pills nav-stacked">
                    @foreach(\App\Utils\BiliBiliHelper::getSorts() as $sort_key=>$sort_value)
                        <li><a href="{{ url('/sort/'.$sort_key) }}">{{ $sort_value }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div class="col-xs-10">

                <nav>
                    <ul class="pager">
                        <li class="previous"><a href="#">最热</a></li>
                        <li class="next"><a href="#">最新</a></li>
                    </ul>
                </nav>

                <div class="row">

                    <h3 class="wb_title_split">{{ $content['name'] }}
                        <small class="wb_small">更新于 2011.12.3</small>
                    </h3>

                    <div class="grid">

                        @foreach($content['list'] as $gird)

                            <div class="grid-item">
                                <a href="#" class="thumbnail tex">
                                    <img src="{{ $gird['pic'] }}"
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
                            <li class="previous"><a href="#"><span aria-hidden="true">&larr;</span> 前一页 </a></li>
                            <li class="next"><a href="#"> 后一页 <span aria-hidden="true">&rarr;</span></a></li>
                        </ul>
                    </nav>
                </div>

            </div>
        </div>

    </div>

@endsection

@section('javascript')
    @parent
    <script src="https://cdnjs.cloudflare.com/ajax/libs/masonry/3.3.1/masonry.pkgd.min.js"></script>

    <script>
        $(document).ready(function () {
            $('.grid').masonry({
                itemSelector: '.grid-item',
                columnLength: 200
            });
        });
    </script>

@endsection
