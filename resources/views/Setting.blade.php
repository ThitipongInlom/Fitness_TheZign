<!doctype html>
<html lang="{{ app()->getLocale() }}">
@if (Session::get('Login.access_rights_setting') == '0')

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
    <style>
        .datepicker{z-index:9999 !important}
        .only-timepicker .datepicker--nav,
        .only-timepicker .datepicker--content {
            display: none;
        }
        .only-timepicker .datepicker--time {
            border-top: none;
        }
    </style>
</head>
<body>
    @include('Head')
    <div class="row">
        <div class="col-md-2">
            <ul class="list-group">
                <li class="list-group-item" id="btn_tab1" style="cursor: pointer;" data-toggle="collapse" data-target="#tab1" aria-expanded="true" aria-controls="tab1">ตั้งค่าประเภท</li>
                <li class="list-group-item" id="btn_tab2" style="cursor: pointer;" data-toggle="collapse" data-target="#tab2" aria-expanded="false" aria-controls="tab2">คั้งค่าคลาส</li>
                <li class="list-group-item" id="btn_tab3" style="cursor: pointer;" data-toggle="collapse" data-target="#tab3" aria-expanded="false" aria-controls="tab3">คั้งค่าตารางคลาส</li>
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
                    <div align="right">
                        <button class="btn btn-sm btn-success" onclick="Add_type();">เพิ่มข้อมูล</button>
                    </div>
                    <table class="table table-sm dt-responsive nowrap  row-border table-bordered table-hover" width="100%" id="Table_type">
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
                        <div align="right" style="padding-bottom: 5px;">
                            <button class="btn btn-sm btn-success" onclick="Add_trainner_emp();">เพิ่มข้อมูล</button>
                        </div>
                        <table class="table table-sm dt-responsive nowrap  row-border table-bordered table-hover" width="100%" id="Table_trainner_emp">
                            <thead>
                                <tr>
                                    <th>ชื่อ นามสกุล Trainner</th>
                                    <th>เทรนเนอร์ประเภท</th>
                                    <th>ตัวช่วย</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ชื่อ นามสกุล Trainner</th>
                                    <th>เทรนเนอร์ประเภท</th>
                                    <th>ตัวช่วย</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- Tab3 -->
                    <div id="tab3" class="collapse" aria-labelledby="tab3" data-parent="#GropSetting">
                        <div align="right" style="padding-bottom: 5px;">
                            <button class="btn btn-sm btn-success" onclick="Add_trainner();">เพิ่มข้อมูล</button>
                        </div>
                        <table class="table table-sm dt-responsive nowrap  row-border table-bordered table-hover" width="100%" id="Table_trainner">
                            <thead>
                                <tr>
                                    <th>ชื่อ นามสกุล</th>
                                    <th>ชื่อประเภท</th>
                                    <th>วันที่สอนประจำ</th>
                                    <th>วันที่ทำการสอน</th>
                                    <th>เวลาที่สอน</th>
                                    <th>ตัวช่วย</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ชื่อ นามสกุล</th>
                                    <th>ชื่อประเภท</th>
                                    <th>วันที่สอนประจำ</th>
                                    <th>วันที่ทำการสอน</th>
                                    <th>เวลาที่สอน</th>
                                    <th>ตัวช่วย</th>
                                </tr>
                            </tfoot>
                        </table>
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
    <div class="modal fade" id="Add_type" tabindex="-1" role="dialog" aria-labelledby="Add_type" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary" style="padding: 0.7rem;">
                    <h5 class="modal-title" id="add_type_Label">เพิ่มประเภท</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                  <div class="row">
                      <div class="col-md-4">
                        <label for="add_type_code"><b>Code ประเภท</b></label>
                        <input type="text" class="form-control" id="add_type_code" placeholder="Code ประเภท">
                      </div>
                      <div class="col-md-4">
                        <label for="add_type_name"><b>ชื่อประเภท</b></label>
                        <input type="text" class="form-control" id="add_type_name" placeholder="ชื่อประเภท">
                      </div>
                      <div class="col-md-4">
                        <label for="add_type_commitment"><b>สิทธ์ต่ออายุแล้วมีส่วนลด</b></label>
                        <select class="form-control" id="add_type_commitment">
                        <option value="0">ไม่มีสิทธิ์</option>
                        <option value="1">มีสิทธิ์</option>
                        </select>
                      </div>                                            
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-md-4">
                        <label for="add_type_day"><b>เลือกวันที่</b></label>
                        <select class="form-control" id="add_type_day">
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                        <option value="13">13</option>
                        <option value="14">14</option>
                        <option value="15">15</option>
                        <option value="16">16</option>
                        <option value="17">17</option>
                        <option value="18">18</option>
                        <option value="19">19</option>
                        <option value="20">20</option>
                        <option value="21">21</option>
                        <option value="22">22</option>
                        <option value="23">23</option>
                        <option value="24">24</option>
                        <option value="25">25</option>
                        <option value="26">26</option>
                        <option value="27">27</option>
                        <option value="28">28</option>
                        <option value="29">29</option>
                        <option value="30">30</option>
                        <option value="31">31</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="add_type_month"><b>เลือกเดือน</b></label>
                        <select class="form-control" id="add_type_month">
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="add_type_year"><b>เลือกปี</b></label>
                        <select class="form-control" id="add_type_year">
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        </select>
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-md-4">
                        <label for="add_free_sum_package"><b>จำนวนที่จะแถม เทรนเนอร์ ฟรี</b></label>
                        <select class="form-control" id="add_free_sum_package">
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        </select>           
                    </div>
                    <div class="col-md-4">
                        <label for="add_price"><b>ราคา</b></label>
                        <input type="text" class="form-control" id="add_price" placeholder="ราคา">         
                    </div>
                    <div class="col-md-4"></div>
                  </div>
                  <hr>
                  <div align="center">
                      <button type="button" class="btn btn-success" onclick="Save_Add_Data();">ยืนยันเพิ่มข้อมูล</button>
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
                  <div class="row">
                      <div class="col-md-4">
                        <label for="edit_type_code"><b>Code ประเภท</b></label>
                        <input type="text" class="form-control" id="edit_type_code" placeholder="Code ประเภท">
                      </div>
                      <div class="col-md-4">
                        <label for="edit_type_name"><b>ชื่อประเภท</b></label>
                        <input type="text" class="form-control" id="edit_type_name" placeholder="ชื่อประเภท">
                      </div>
                      <div class="col-md-4">
                        <label for="edit_type_commitment"><b>สิทธ์ต่ออายุแล้วมีส่วนลด</b></label>
                        <select class="form-control" id="edit_type_commitment">
                        <option value="0">ไม่มีสิทธิ์</option>
                        <option value="1">มีสิทธิ์</option>
                        </select>
                      </div>                                            
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-md-4">
                        <label for="edit_type_day"><b>เลือกวันที่</b></label>
                        <select class="form-control" id="edit_type_day">
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                        <option value="13">13</option>
                        <option value="14">14</option>
                        <option value="15">15</option>
                        <option value="16">16</option>
                        <option value="17">17</option>
                        <option value="18">18</option>
                        <option value="19">19</option>
                        <option value="20">20</option>
                        <option value="21">21</option>
                        <option value="22">22</option>
                        <option value="23">23</option>
                        <option value="24">24</option>
                        <option value="25">25</option>
                        <option value="26">26</option>
                        <option value="27">27</option>
                        <option value="28">28</option>
                        <option value="29">29</option>
                        <option value="30">30</option>
                        <option value="31">31</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="edit_type_month"><b>เลือกเดือน</b></label>
                        <select class="form-control" id="edit_type_month">
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="edit_type_day"><b>เลือกปี</b></label>
                        <select class="form-control" id="edit_type_year">
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        </select>
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-md-4">
                        <label for="edit_free_sum_package"><b>จำนวนที่จะแถม เทรนเนอร์ ฟรี</b></label>
                        <select class="form-control" id="edit_free_sum_package">
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        </select>    
                    </div>
                    <div class="col-md-4">
                        <label for="edit_price"><b>ราคา</b></label>
                        <input type="text" class="form-control" id="edit_price" placeholder="ราคา">         
                    </div>
                    <div class="col-md-4"></div>
                  </div>
                  <hr>
                  <div align="center">
                      <button type="button" class="btn btn-success" onclick="Save_Edit_Data();">ยืนยันการแก้ไข</button>
                      <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
                  </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="Add_trainner" tabindex="-1" role="dialog" aria-labelledby="Add_trainner_Label" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary" style="padding: 0.7rem;">
                    <h5 class="modal-title" id="Add_trainner_Label">เพิ่มข้อมูลเทรนเนอร์</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label for="select_trianner_emp">เลือกผู้สอน เทรนเนอร์</label>
                            <span id="select_trianner_emp"></span>                      
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="date_trainner">เลือก วันที่จะสอน</label>
                            <div class="input-group">
                            <input type="text" data-toggle="datepicker" data-date-format='dd/mm/yyyy' class="form-control" id="date_trainner_add"  placeholder="เลือกวันที่จะสอน" autocomplete="off">
                            <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                            <span id="foo"></span>
                            </div>
                            </div>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="select_trainner_class">เลือก คลาสที่จะสอน</label>
                            <span id="select_trainner_class"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check">
                               <input type="radio" class="form-check-input" name="exampleRadios" id="Check_1" checked value="no">
                               <label class="form-check-label" for="Check_1">ไม่ทำซ้ำ</label>
                            </div>
                            <div class="form-check">
                               <input type="radio" class="form-check-input" name="exampleRadios" id="Check_2" value="repeat">
                               <label class="form-check-label" for="Check_2">ทำซ้ำครั้งเดียว</label>
                            </div>
                            <div class="form-check">
                               <input type="radio" class="form-check-input" name="exampleRadios" id="Check_3" value="every_genday">
                               <label class="form-check-label" for="Check_2">ทำซ้ำตลอด</label>
                            </div>   
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="input_trainner_time_start">เลือกเวลาที่เริ่มสอน</label>
                            <input type="text" class="form-control only-time" id="input_trainner_time_start" placeholder="เลือกเวลาที่เริ่มสอน" autocomplete="off">
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="input_trainner_time_end">เลือกเวลาที่สอนสิ้นสุด</label>
                            <input type="text" class="form-control only-time" id="input_trainner_time_end" placeholder="เลือกเวลาที่สอนสิ้นสุด" autocomplete="off">
                        </div>
                    </div>
                    <hr>
                    <div align="center">
                        <button class="btn btn-sm btn-success" onclick="Save_trainner();">ยืนยันการสร้าง</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="Edit_trainner" tabindex="-1" role="dialog" aria-labelledby="Add_trainner_Label" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary" style="padding: 0.7rem;">
                    <h5 class="modal-title" id="Add_trainner_Label">แก้ไขข้อมูลเทรนเนอร์</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label for="select_trianner_emp_edit">เลือกผู้สอน เทรนเนอร์</label>
                            <span id="select_trianner_emp_edit"></span>                      
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="date_trainner">เลือก วันที่จะสอน</label>
                            <div class="input-group">
                            <input type="text" data-toggle="datepicker" data-date-format='dd/mm/yyyy' class="form-control" id="date_trainner_edit"  placeholder="เลือกวันที่จะสอน">
                            <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                            <span id="foo"></span>
                            </div>
                            </div>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="select_trainner_class_edit">เลือก คลาสที่จะสอน</label>
                            <span id="select_trainner_class_edit"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check">
                               <input type="radio" class="form-check-input" name="exampleRadios_edit" id="Check_1_edit" value="no">
                               <label class="form-check-label" for="Check_1">ไม่ทำซ้ำ</label>
                            </div>
                            <div class="form-check">
                               <input type="radio" class="form-check-input" name="exampleRadios_edit" id="Check_2_edit" value="repeat">
                               <label class="form-check-label" for="Check_2">ทำซ้ำครั้งเดียว</label>
                            </div>
                            <div class="form-check">
                               <input type="radio" class="form-check-input" name="exampleRadios_edit" id="Check_3_edit" value="every_genday">
                               <label class="form-check-label" for="Check_2">ทำซ้ำตลอด</label>
                            </div>   
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="input_trainner_time_start">เลือกเวลาที่เริ่มสอน</label>
                            <input type="text" class="form-control only-time" id="input_trainner_time_start_edit" placeholder="เลือกเวลาที่เริ่มสอน">
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="input_trainner_time_end">เลือกเวลาที่สอนสิ้นสุด</label>
                            <input type="text" class="form-control only-time" id="input_trainner_time_end_edit" placeholder="เลือกเวลาที่สอนสิ้นสุด">
                        </div>
                    </div>
                    <hr>
                    <div align="center">
                        <button class="btn btn-sm btn-success" onclick="Save_trainner_edit();">ยืนยันการสร้าง</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="Add_trainner_emp" tabindex="-1" role="dialog" aria-labelledby="Add_trainner_emp" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary" style="padding: 0.7rem;">
                    <h5 class="modal-title" id="Add_trainner_emp_Label">เพิ่มข้อมูลพนักงาน ผู้สอน PT</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4 form-group">
                        <label for="firstname_trainner">ชื่อ - ผุ้สอน</label>
                        <input type="text" class="form-control" id="firstname_trainner" placeholder="First name">
                        </div>
                        <div class="col-md-4  form-group">
                        <label for="lastname_trainner">นามสกุล - ผู้สอน</label>
                        <input type="text" class="form-control" id="lastname_trainner" placeholder="Last name">
                        </div>
                        <div class="col-md-4 form-group">
                        <label for="classname_trainner">เลือกประเภทการสอน</babel>
                        <div style="padding-bottom: 8px;"></div>
                        <select class="custom-select" id="classname_trainner">
                            <option value="0" selected>เลือก Class ที่ เทรนเนอร์ สอน</option>
                            <option value="Class">[CL] คลาส</option>
                            <option value="Personal Trainer">[PT] เทรนเนอร์</option>
                            <option value="ALL">[ALL] ทั้งหมด</option>
                        </select>
                        </div>
                    </div>
                    <hr style="margin-top: 5px;">
                    <div class="row">
                        <div class="col-md-12">
                            <div align="center">
                                <button class="btn btn-success" onclick="Save_Trainner_emp();">บันทึก</button>
                                <button class="btn btn-danger" data-dismiss="modal">ปิด</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="Edit_Trainner_emp" tabindex="-1" role="dialog" aria-labelledby="Edit_Trainner_emp" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary" style="padding: 0.7rem;">
                    <h5 class="modal-title" id="Edit_Trainner_emp_Label">แก้ไขข้อมูลพนักงาน ผู้สอน PT</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" id="hidden_trainner_emp_id">
                        <div class="col-md-4 form-group">
                        <label for="firstname_trainner">ชื่อ - ผุ้สอน</label>
                        <input type="text" class="form-control" id="firstname_trainner_edit" placeholder="First name">
                        </div>
                        <div class="col-md-4  form-group">
                        <label for="lastname_trainner">นามสกุล - ผู้สอน</label>
                        <input type="text" class="form-control" id="lastname_trainner_edit" placeholder="Last name">
                        </div>
                        <div class="col-md-4 form-group">
                        <label for="classname_trainner">เลือกประเภทการสอน</babel>
                        <div style="padding-bottom: 8px;"></div>
                        <select class="custom-select" id="classname_trainner_edit">
                            <option value="0" selected>เลือก Class ที่ เทรนเนอร์ สอน</option>
                            <option value="Class">[CL] คลาส</option>
                            <option value="Personal Trainer">[PT] เทรนเนอร์</option>
                            <option value="ALL">[ALL] ทั้งหมด</option>
                        </select>
                        </div>
                    </div>
                    <hr style="margin-top: 5px;">
                    <div class="row">
                        <div class="col-md-12">
                            <div align="center">
                                <button class="btn btn-success" onclick="Save_edit_Trainner_emp();">อัพเดต</button>
                                <button class="btn btn-danger" data-dismiss="modal">ปิด</button>
                            </div>
                        </div>
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
<!-- Use Script -->
<script type="text/javascript">
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
        var datepicker = $('[data-toggle="datepicker"]').datepicker({
          language: 'en',
          autoClose: true,
        });
    });
</script>
</html>