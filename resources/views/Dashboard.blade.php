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
            <div class="col-lg-4 col-6">
                <div class="small-box bg-info shadow">
                    <div class="inner">
                        <h3 class="text-white">Report</h3>
                        <p class="text-white">รออัพเดต</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-cogs"></i>
                    </div>
                </div>
            </div>
            <!-- users -->
            <div class="col-lg-4 col-6" onclick="MainUsers();">
                <div class="small-box bg-success shadow">
                    <div class="inner">
                        <h3 class="text-white">Member</h3>
                        <p class="text-white">เพิ่ม Member เข้าสู่ระบบและสร้าง WiFi</p>
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

    <!-- Modal -->
    <div class="modal fade" id="Find_the_name" tabindex="-1" role="dialog" aria-labelledby="Find_the_name_Label" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="Find_the_name_Label">ค้นหาชื่อ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row" align="center">
                        <div class="col-md-4">
                            <div id="namesearchingstatus"></div>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control form-control-sm" name="namesearching" id="namesearching" placeholder="ค้นหาชื่อลูกค้า" onkeypress="if (event.keyCode==13){ searchingname(this);return false;}">
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-sm btn-outline-primary" onclick="searchinguse();">ลูกค้า Active</button>
                            <button class="btn btn-sm btn-outline-success" onclick="searchingall();">ลูกค้าทั้งหมด</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div id="table_find_name"></div>
                        </div>
                    </div>
                    <hr>
                    <div align="center">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
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
<!-- Checkin Js -->
<script type="text/javascript" src="{{ url('js/Checkin.js') }}"></script>
<!-- Use Script -->
<script type="text/javascript">
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
    var MainUsers = function MainUsers() {
        window.location = "{{ url('/MainUsers') }}";
    }
</script>

</html>
