<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Fitness</title>
    <!-- All Css -->
    <link rel="stylesheet" type="text/css" href="{{ url('css/app.css') }}">
    <!-- animate -->
    <link rel="stylesheet" type="text/css" href="{{ url('css/animate.css') }}">
</head>

<body class="login-page">
    @include('Head')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @include('layout.choose_card')
            </div>
        </div>
    </div>
    <div class="row">
        @include('layout.card')
    </div>
</body>
<!-- All Js -->
<script type="text/javascript" src="{{ url('js/app.js') }}"></script>
<!-- Welcome Js -->
<script type="text/javascript" src="{{ url('js/welcome.js') }}"></script>

</html>
