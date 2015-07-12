@extends('pusher.layout')

@section('content')

    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <ul class="nav nav-pills nav-stacked mrm">
                        <li>
                            <a href="#">添加关注</a>
                        </li>

                        <li>
                            <a href="#">设置邮箱</a>
                        </li>

                        <li>
                            <a href="#">查看日志</a>
                        </li>
                    </ul>
                </div>

            </div>

        </div>
        <div class="col-md-8">
            <ul class="list-group">
                <li class="list-group-item">
                    <span class="badge">14</span>
                    Cras justo odio
                </li>
            </ul>
        </div>
    </div>


@endsection