<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>登陆</title>

    <link href="{{ url('bootstrap/css/bootstrap.css') }}" rel="stylesheet" type="text/css"/>

    <style>
        body {
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #eee;
        }

        .form-signin {
            max-width: 330px;
            padding: 15px;
            margin: 10px auto;
        }

        .form-signin .form-signin-heading,
        .form-signin .checkbox {
            margin-bottom: 10px;
        }

        .form-signin .checkbox {
            font-weight: normal;
        }

        .form-signin .form-control {
            margin-top: 10px;
            position: relative;
            height: auto;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            padding: 10px;
            font-size: 16px;
        }

        .form-signin .form-control:focus {
            z-index: 2;
        }

        .form-signin input[type="email"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }

        .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }

    </style>
</head>
<body>


<div class="container">

    @if (count($errors) > 0)
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-ban"></i> 警告!</h4>

            <p>{!! $errors->first() !!}</p>
        </div>
    @endif

    @if(Session::has('message'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> 提示！</h4>
            {{ Session::get('message') }}
        </div>
    @endif

    <form class="form-signin" method="POST" action="{{ url('auth/postRegister') }}">
        <h2 class="form-signin-heading">注册</h2>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input name="email" type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
        <label for="inputName" class="sr-only">Your name</label>
        <input name="username" type="text" id="inputName" class="form-control" placeholder="Your name" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <label for="inputPassword2" class="sr-only">Password again</label>
        <input name="password_confirmation" type="password" id="inputPassword2" class="form-control" placeholder="Confirm password" required>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">


        <button class="btn btn-lg btn-primary btn-block" type="submit">现在加入</button>
    </form>

</div>

<script src="{{ url('semantic/js/jquery-2.1.3.min.js') }}"></script>
<script src="{{ url('bootstrap/js/bootstrap.js') }}"></script>

</body>
</html>