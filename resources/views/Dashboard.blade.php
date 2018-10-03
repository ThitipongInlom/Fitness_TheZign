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
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
</head>

<body>
    @include('Head')
    <div class="container">
        <div class="row">
            <!-- MainCheck -->
            <div class="col-lg-4 col-6" onclick="MainCheck();">
                <div class="small-box bg-info shadow">
                    <div class="inner">
                        <h3 class="text-white">MainCheck</h3>
                        <p class="text-white">ลูกค้าใช้บริการที่ Fitness</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-door-open"></i>
                    </div>
                </div>
            </div>
            <!-- Wait -->
            <div class="col-lg-4 col-6">
                <div class="small-box bg-success shadow">
                    <div class="inner">
                        <h3 class="text-white">Wait</h3>
                        <p class="text-white">รอ</p>
                    </div>
                    <div class="icon">
                        <i class="fab fa-accessible-icon"></i>
                    </div>
                </div>
            </div>
            <!-- Wait -->
            <div class="col-lg-4 col-6">
                <div class="small-box bg-danger shadow">
                    <div class="inner">
                        <h3 class="text-white">Wait</h3>
                        <p class="text-white">รอ</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-ambulance"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<!-- All Js -->
<script type="text/javascript" src="{{ url('js/app.js') }}"></script>
<!-- Dashboard -->
<script type="text/javascript" src="{{ url('js/dashboard.js') }}"></script>
<!-- Use Script -->
<script type="text/javascript">
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
    var MainCheck = function MainCheck() {
        window.location = "{{ url('/MainCheck') }}";
    }
</script>

</html>
