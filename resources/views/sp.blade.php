@extends('common.layout')

@section('title', '专题:'.$content['title'])

@section('css')
    @parent

@endsection

@section('content')

    <div class="sp_intro">
        <img src="{{ $content['cover'] }}">

        <div class="sp_intro_content">
            <h1>{{ $content['title'] }}</h1>

            <p>{{ $content['description'] }}</p>
        </div>
    </div>

    <nav>
        <ul class="pager">
            <li class="previous"><a href="javascript:void(0)" id="change_other"><span aria-hidden="true">&larr;</span>
                    其他</a>
            </li>
            <li class="next"><a href="javascript:void(0)" id="change_bangumi">番剧 <span aria-hidden="true">&rarr;</span></a>
            </li>
        </ul>
    </nav>

    <h3 class="wb_title_split">相关视频</h3>

    <div class="row sp_content">

    </div>

@endsection

@section('javascript')
    @parent

    <script>
        $(document).ready(function () {
            var container = $('.sp_content');

            function add_videos(type) {
                container.empty();
                $.get("/spvideo/{{$content['spid']}}?type=" + type, function (data, status) {
                    if (data.code == 'success') {
                        var list = data.content.list;
                        for (var i in list) {
                            var video = '<div class="col-md-3"><a class="wb-show wb-show_middle wb_hidden" style="display: none" href="/view/' + list[i].aid + '" target="_blank">' +
                                    '<img src="' + list[i].cover + '" style="max-height: 120px"><div class="caption">' +
                                    '<p>' + list[i].title + '</p></div></a></div>';
                            container.append(video);
                        }
                        $('.wb_hidden').fadeIn();
                    }
                });
            }
            add_videos(1);

            $('#change_other').click(function () {
                add_videos(0);
            });

            $('#change_bangumi').click(function () {
                add_videos(1);
            });
        });
    </script>

@endsection
