@extends('pusher.layout')


@section('content')

    <div class="row">
        <div class="container">
            <div class="col-xs-2 well">
                <ul class="nav nav-pills nav-stacked">
                    <li><a href="{{ url('list') }}">默认</a></li>

                    @foreach($sorts as $li)
                        <li><a href="{{ url('list?tid='.$li->tid) }}">{{ $li->title }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div class="col-xs-10">


                <div class="page-header">
                    <div class="row">

                        @for($i=0;$i<4;$i++)
                            <div class="col-md-3">
                                <a href="{{ url('/view/'.$hots[$i]['aid']) }}" class="thumbnail" target="_blank">
                                    <img src="{{ $hots[$i]['pic'] }}"
                                         alt="{{ $hots[$i]['title'] }}">
                                </a>
                            </div>
                        @endfor

                    </div>

                </div>


                <nav>
                    <ul class="pager">
                        <li class="previous"><a href="#">最热</a></li>
                        <li class="next"><a href="#">最新</a></li>
                    </ul>
                </nav>

                <div class="row">
                    <div class="grid">

                        @foreach($list as $video)
                            @if(isset($video['aid']))
                                <div class="grid-item">
                                    <a href="{{ url('/view/'.$video['aid']) }}" class="thumbnail tex" target="_blank">
                                        <img src="{{ $video['pic'] }}"
                                             alt="...">

                                        <div class="caption">
                                            <p>{{ $video['title'] }}</p>
                                        </div>
                                    </a>
                                </div>
                            @endif
                        @endforeach

                    </div>

                </div>

                <div class="row text-center">
                    <?php echo $paginator->appends(['tid' => $tid])->render(); ?>
                </div>

            </div>
        </div>

    </div>

@endsection

@section('javascript')
    @parent
    <script src="https://cdnjs.cloudflare.com/ajax/libs/masonry/3.3.1/masonry.pkgd.min.js"></script>

    <script>
        window.onload = function () {
            $('.grid').masonry({
                itemSelector: '.grid-item'
            });
        }
    </script>

@endsection