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
            <div class="col-lg-3 col-6" onclick="Report();">
                <div class="small-box bg-info shadow" style="cursor: pointer;">
                    <div class="inner">
                        <h3 class="text-white" style="cursor: pointer;">Report</h3>
                        <p class="text-white" style="cursor: pointer;">สรุปรายงานข้อมูลการใช้งานต่างๆ</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-cogs"></i>
                    </div>
                </div>
            </div>
            <!-- users -->
            <div class="col-lg-3 col-6" onclick="MainUsers();">
                <div class="small-box bg-success shadow" style="cursor: pointer;">
                    <div class="inner">
                        <h3 class="text-white" style="cursor: pointer;">Member</h3>
                        <p class="text-white" style="cursor: pointer;">เพิ่ม Member</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
            <!-- sliders -->
            <div class="col-lg-3 col-6" onclick="Setting();">
                <div class="small-box bg-danger shadow" style="cursor: pointer;">
                    <div class="inner">
                        <h3 class="text-white" style="cursor: pointer;">Setting</h3>
                        <p class="text-white" style="cursor: pointer;">ตั้งค่ารายละเอียดต่างๆ</p>
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
                <div class="modal-header bg-primary" style="padding: 0.7rem;">
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

    <!-- Modal -->
    <div class="modal fade" id="Find_thezign_name" tabindex="-1" role="dialog" aria-labelledby="Find_the_name_Label" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary" style="padding: 0.7rem;">
                    <h5 class="modal-title" id="Find_the_name_Label">ค้นหาห้องลูกค้า</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                  <div class="row" align="center">
                      <div class="col-md-4">
                          ค้นหารายห้องลูกค้าTheZign
                      </div>
                      <div class="col-md-4">
                          <input type="text" class="form-control form-control-sm" name="namesearching" id="namesearchingthezign" placeholder="ค้นหารายห้องลูกค้าTheZign" onkeypress="if (event.keyCode==13){ Airlink_modal_data(this);return false;}">
                      </div>
                      <div class="col-md-4">
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-12">
                          <div id="table_find_name_thezign"></div>
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
    var Report = function Report() {
        window.location = "{{ url('/Report') }}";
    }
    var MainUsers = function MainUsers() {
        if ({{ Session::get('Login.access_rights_member') }} == '0') {
            window.location = "{{ url('/MainUsers') }}";
        }else {
            alert('ไม่มีสิทธ์การเข้าการใช้งานส่วนนี้');
        }
    }
    var Setting = function Setting(){
        if ({{ Session::get('Login.access_rights_setting') }} == '0') {
            window.location = "{{ url('/Setting') }}";
        }else {
            alert('ไม่มีสิทธ์การเข้าการใช้งานส่วนนี้');
        }
    }
</script>

</html>
