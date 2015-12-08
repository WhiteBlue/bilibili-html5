@extends('common.layout')

@section('title', '番剧列表')

@section('css')
    @parent

@endsection


@section('content')

    <div class="bangumi_title">
        <p>番剧列表</p>
    </div>

    <div id="bangumi_view_container">
        <div id="bangumi_view_content">
            <ul style="padding-left: 0">

                <li class="bangumi_view_li">
                    <p class="bangumi_view_time">今日 : {{ \App\Utils\DateUtil::getDate($today) }}</p>

                    <div class="bangumi_view_element_container">

                        @foreach($content[$today] as $animation)
                            <a href="{{ url('/sp/'.$animation['title']) }}">
                                <div class="bangumi_view_element wb_action_element">
                                    <img src="{{ $animation['cover'] }}" alt="bangumi_logo">

                                    <div class="bangumi_view_element_info">
                                        <h2>{{ $animation['title'] }}</h2>

                                        <p>最后更新 : {{ $animation['lastupdate_at'] }}</p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <div class="row clear_elements"></div>

                    <div class="clear"></div>

                </li>

                @foreach($content as $day=>$animations)
                    @if($day!=$today)

                        <li class="bangumi_view_li">
                            <p class="bangumi_view_time">{{ \App\Utils\DateUtil::getDate($day) }}</p>

                            <div class="bangumi_view_element_container">

                                @foreach($animations as $index=>$other)
                                    @if($index>3) 
                                    <a href="{{ url('/sp/'.$other['title']) }}"> 
                                        <div class="bangumi_view_element wb_action_element wb_hidden_{{ $day }}"  
                                             style="display: none">  <img src="{{ $other['cover'] }}"
                                                                          alt="bangumi_logo">  
                                            <div class="bangumi_view_element_info"> 
                                                <h2>{{ $other['title'] }}</h2>  
                                                <p>最后更新 : {{ $other['lastupdate_at'] }}</p> 
                                            </div>

                                        </div>
                                         </a>
                                     @else
                                        <a href="{{ url('/sp/'.$other['title']) }}">
                                            <div class="bangumi_view_element wb_action_element">
                                                <img src="{{ $other['cover'] }}" alt="bangumi_logo">

                                                <div class="bangumi_view_element_info">
                                                    <h2>{{ $other['title'] }}</h2>

                                                    <p>最后更新 : {{ $other['lastupdate_at'] }}</p> 
                                                </div>
                                            </div>
                                        </a>
                                    @endif
                                @endforeach

                                <div class="row clear_elements">
                                    <a class="wb_action_text wb_action_toggle" action="wb_hidden_{{ $day }}"
                                       href="javascript:void(0);">加载更多↓↓</a>
                                </div>
                            </div>
                            <div class="clear"></div>
                        </li>
                    @endif
                @endforeach

            </ul>
        </div>
    </div>


@endsection

@section('javascript')
    @parent

    <script>
        $(document).ready(function () {
            $('.wb_action_toggle').click(function () {
                $('.' + $(this).attr('action')).slideToggle();
                $(this).hide();
            });
        });
    </script>

@endsection
