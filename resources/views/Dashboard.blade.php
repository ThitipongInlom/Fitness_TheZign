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
                        <p class="text-white">ลูกค้ามาใช้บริการที่ Fitness</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-door-open"></i>
                    </div>
                </div>
            </div>
            <!-- users -->
            <div class="col-lg-4 col-6" onclick="MainUsers();">
                <div class="small-box bg-success shadow">
                    <div class="inner">
                        <h3 class="text-white">Users</h3>
                        <p class="text-white">เพิ่มลูกค้าเข้าสู่ระบบและสร้างWiFi</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
            <!-- sliders -->
            <div class="col-lg-4 col-6">
                <div class="small-box bg-danger shadow">
                    <div class="inner">
                        <h3 class="text-white">Setting</h3>
                        <p class="text-white">ตั้งค่ารายละเอียดต่างๆ</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-sliders-h"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<footer>
  <div class="row">
      @include('layout.card')
  </div>
</footer>
<!-- All Js -->
<script type="text/javascript" src="{{ url('js/app.js') }}"></script>
<!-- Dashboard -->
<script type="text/javascript" src="{{ url('js/dashboard.js') }}"></script>
<!-- Welcome Js -->
<script type="text/javascript" src="{{ url('js/welcome.js') }}"></script>
<!-- Use Script -->
<script type="text/javascript">
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
    var MainCheck = function MainCheck() {
        window.location = "{{ url('/CheckIn') }}";
    }
    var MainUsers = function MainUsers() {
        window.location = "{{ url('/MainUsers') }}";
    }
</script>

</html>
