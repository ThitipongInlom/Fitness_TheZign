<!doctype html>
<html lang="{{ app()->getLocale() }}">
@if (Session::get('Login.status') == '0')

@else
  <script>
      window.location = "{{ url('/Dashboard') }}";
  </script>
@endif
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
    <div class="row">
        <div class="col-md-2">
            <ul class="list-group">
                <li class="list-group-item" id="btn_tab1" style="cursor: pointer;" data-toggle="collapse" data-target="#tab1" aria-expanded="true" aria-controls="tab1">ตั้งค่าประเภท</li>
                <li class="list-group-item" id="btn_tab2" style="cursor: pointer;" data-toggle="collapse" data-target="#tab2" aria-expanded="false" aria-controls="tab2">ตั้งค่าที่2</li>
            </ul>
        </div>
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    <div id="GropSetting">
                    <!-- ค่าเริ่มต้น -->
                    <div id="ShowAdd">
                       <div align="center"><h5 style="color:red;">กรุณาเลือก เมนูที่ทางซ้ายมือ </h5></div>
                    </div>
                    <!-- Tab1 -->
                    <div id="tab1" class="collapse" aria-labelledby="tab1" data-parent="#GropSetting">
                    <table class="table table-sm dt-responsive nowrap  row-border table-bordered table-hover" width="100%" id="Table_tab1">
                        <thead>
                            <tr>
                                <th>Code ประเภท</th>
                                <th>ชื่อประเภท</th>
                                <th>จำนวนวัน</th>
                                <th>จำนวนเดือน</th>
                                <th>จำนวนปี</th>
                                <th>ราคา</th>
                                <th>สิทธ์</th>
                                <th>ตัวช่วย</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Code ประเภท</th>
                                <th>ชื่อประเภท</th>
                                <th>จำนวนวัน</th>
                                <th>จำนวนเดือน</th>
                                <th>จำนวนปี</th>
                                <th>ราคา</th>
                                <th>สิทธ์</th>
                                <th>ตัวช่วย</th>
                            </tr>
                        </tfoot>
                    </table>
                    </div>
                    <!-- Tab2 -->
                    <div id="tab2" class="collapse" aria-labelledby="tab2" data-parent="#GropSetting">
                    2
                    </div>
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
                    <h5 class="modal-title" id="Find_the_name_Label">ค้นหาห้อง</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                  <div class="row" align="center">
                      <div class="col-md-4">
                          ค้นหาห้องลูกค้าTheZign
                      </div>
                      <div class="col-md-4">
                          <input type="text" class="form-control form-control-sm" name="namesearching" id="namesearchingthezign" placeholder="ค้นหาห้องลูกค้าTheZign" onkeypress="if (event.keyCode==13){ Airlink_modal_data(this);return false;}">
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

    <!-- Modal -->
    <div class="modal fade" id="Edit_Type" tabindex="-1" role="dialog" aria-labelledby="Edit_Type" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary" style="padding: 0.7rem;">
                    <h5 class="modal-title" id="Edit_Type_Label">แก้ไขประเภท</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                  <input type="hidden" id="hidden_type_id">
                  <div class="row" align="center">
                      <div class="col-md-4">
                        <input type="text" class="form-control" id="edit_type_code" placeholder="Code ประเภท">
                      </div>
                      <div class="col-md-4">
                        <input type="text" class="form-control" id="edit_type_name" placeholder="ชื่อประเภท">
                      </div>
                      <div class="col-md-4">
                        <select class="form-control" id="edit_type_commitment">
                        <option>ไม่มีสิทธิ์</option>
                        <option>มีสิทธิ์</option>
                        </select>
                      </div>                                            
                  </div>
                  <hr>
                  <div align="center">
                      <button type="button" class="btn btn-success">ยืนยันการแก้ไข</button>
                      <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
                  </div>
                </div>
            </div>
        </div>
    </div>

</body>
<!-- All Js -->
<script type="text/javascript" src="{{ url('js/app.js') }}"></script>
<!-- Checkin Js -->
<script type="text/javascript" src="{{ url('js/Checkin.js') }}"></script>
<!-- Setting -->
<script type="text/javascript" src="{{ url('js/setting.js') }}"></script>
</html>