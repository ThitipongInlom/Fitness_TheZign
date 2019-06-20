<!doctype html>
<html lang="{{ app()->getLocale() }}">
@if (Session::get('Login.access_rights_member') == '0')

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
    <!-- Css font -->
    <style>
      .TableDisplay{
        font-size: 12px;
      }
      #toTop{
      	position: fixed;
      	bottom: 10px;
      	left: 50%;
      	cursor: pointer;
      	display: none;
      }
      .upload-btn-wrapper {
        position: relative;
        overflow: hidden;
        display: inline-block;
      }
      .upload-btn-wrapper input[type=file] {
        font-size: 100px;
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
      }
      .formmaginsetnone{
        margin-bottom: 0rem !important;
      }
      .bg-tablecolor {
        background-color: #d7e4ef !important;
      }
      .bg-tablecolor_set {
        background-color: #96c8f1 !important;
      }
      .devcon-badge {
          z-index: 100;
          background: linear-gradient(90deg,#fca09a,#fcccd3,#ffcc9d,#98ddad,#81d7ec,#a0aaed);
          background-size: 200%;
          text-align: center;
          -webkit-animation: AnimationName 5s ease infinite;
          -moz-animation: GradientAnimation 5s ease infinite;
          animation: GradientAnimation 5s ease infinite;
      }
      .datepicker{z-index:9999 !important}
    </style>
</head>
<body>
    @include('Head')
    <div class="card">
        <div class="card-body" style="padding: 0.75rem;">
            <div class="row">
              <div class="col-md-2">
                <input type="text" id="searchingcode" class="form-control form-control-sm" placeholder="ค้นหา Code">
              </div>
              <div class="col-md-2">
                <select class="custom-select custom-select-sm" id="searchingselect">
                  <option selected value="All">ค้นหาลูกค้าฟิตเน็ตทั้งหมด</option>
                  <option value="Active">ค้าหาลูกค้า Active</option>
                  <option value="Expired">ค้าหาลูกค้า Expired</option>
                  <option value="Hotel">ค้าหาลูกค้า Hotel</option>
                </select>
              </div>
              <div class="col-md-7">
                  <button class="btn btn-sm btn-primary" type="submit" id="searchTableDisplay">ค้นหา</button>
              </div>
              <div class="col-md-1">
                  <button class=" btn btn-sm btn-success" type="btton" onclick="AddUsermodel();">เพิ่มลูกค้า</button>
              </div>
            </div>
            <hr>
            <div class="row">
            <div class="col-md-12">
            <div class="table-responsive">
            <table class="table table-sm dt-responsive nowrap row-border table-bordered table-hover TableDisplay" cellspacing="0" cellpadding="0" id="TableDisplay" width="100%">
                <thead>
                    <tr align="center" class="bg-primary">
                        <th>Code</th>
                        <th>Pass</th>
                        <th width="7%">Name</th>
                        <th>Start</th>
                        <th>Expire</th>
                        <th>Birthday</th>
                        <th>Phone</th>
                        <th>Type</th>
                        <th>Address</th>
                        <th>Status</th>
                        <th>ผู้ดำเนินการ</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr align="center" class="bg-primary">
                        <th>Code</th>
                        <th>Pass</th>
                        <th>Name</th>
                        <th>Start</th>
                        <th>Expire</th>
                        <th>Birthday</th>
                        <th>Phone</th>
                        <th>Type</th>
                        <th>Address</th>
                        <th>Status</th>
                        <th>ผู้ดำเนินการ</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>
            </div>
              </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="ViewDataUser" tabindex="-1" role="dialog" aria-labelledby="ViewDataUser" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary" style="padding: 0.7rem;">
                    <h5 class="modal-title">ดูข้อมูลลูกค้า</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div align="center">
                        <div id="ViewDataUserDisplay"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="AddUsermodel" tabindex="-1" role="dialog" aria-labelledby="AddUsermodel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary" style="padding: 0.7rem;">
                    <h5 class="modal-title">เพิ่มลูกค้า</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div align="left">
                      <form id="FormAdd_User">
                        <div class="form-group formmaginsetnone row">
                          <label for="Code_Add" class="col-sm-3 col-form-label">Code :</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control form-control-sm" id="Code_Add" placeholder="Gen Code Auto" disabled>
                          </div>
                        </div>
                        <div class="form-group formmaginsetnone row">
                          <label for="Name_Add" class="col-sm-3 col-form-label">ชื่อลูกค้า :</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control form-control-sm" id="Name_Add" placeholder="ชื่อลูกค้า">
                          </div>
                        </div>
                        <div class="form-group formmaginsetnone row">
                          <label for="Start_Add" class="col-sm-3 col-form-label">วันที่เริ่มต้น :</label>
                          <div class="col-sm-9">
                              <div class="input-group">
                                <input type="text" data-toggle="datepicker" data-date-format='dd/mm/yyyy' class="form-control form-control-sm" id="Start_Add" placeholder="วันที่เริ่มต้น">
                                <div class="input-group-append">
                                  <button type="button" class="btn btn-sm btn-outline-secondary docs-datepicker-trigger" disabled="">
                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                  </button>
                                </div>
                              </div>
                          </div>
                        </div>
                        <div class="form-group formmaginsetnone row">
                          <label for="End_Add" class="col-sm-3 col-form-label">วันที่สิ้นสุด :</label>
                          <div class="col-sm-9">
                            <div class="input-group">
                              <input type="text" data-toggle="datepicker" data-date-format='dd/mm/yyyy' class="form-control form-control-sm" id="End_Add" placeholder="วันที่สิ้นสุด คำนวนจากการเลือกประเภท" disabled>
                              <div class="input-group-append">
                                <button type="button" class="btn btn-sm btn-outline-secondary docs-datepicker-trigger" disabled="">
                                  <i class="fa fa-calendar" aria-hidden="true"></i>
                                </button>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group formmaginsetnone row">
                          <label for="Birthday_Add" class="col-sm-3 col-form-label">วันเดือนปีเกิด :</label>
                          <div class="col-sm-9">
                            <div class="input-group">
                              <input type="text" data-toggle="datepicker" data-date-format='dd/mm/yyyy' class="form-control form-control-sm" id="Birthday_Add" placeholder="วันเดือนปีเกิด">
                              <div class="input-group-append">
                                <button type="button" class="btn btn-sm btn-outline-secondary docs-datepicker-trigger" disabled="">
                                  <i class="fa fa-calendar" aria-hidden="true"></i>
                                </button>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group formmaginsetnone row">
                          <label for="Phone_Add" class="col-sm-3 col-form-label">เบอร์โทร :</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control form-control-sm" id="Phone_Add" placeholder="เบอร์โทร">
                          </div>
                        </div>
                        <div class="form-group formmaginsetnone row">
                          <label for="Address_Add" class="col-sm-3 col-form-label">ที่อยู่ :</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control form-control-sm" id="Address_Add" placeholder="ที่อยู่">
                          </div>
                        </div>
                        <div class="form-group formmaginsetnone row">
                          <label for="Type_Add" class="col-sm-3 col-form-label">ประเภท :</label>
                          <div class="col-sm-9">
                            <select class="custom-select custom-select-sm" id="Type_Add" onchange="Calculate_Day(this);">
                              <option selected value="0">เลือกประเภท</option>
                              @foreach (MainUsers::GetTypeData() as $key => $row)
                              <option value="{{ $row->type_id }}" @if ($row->type_code == 'Stop') {{ 'disabled' }}  @endif><b>[ {{ $row->type_code }} ] </b> {{ $row->type_value }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="form-group formmaginsetnone row">
                          <label for="Price_full_Add" class="col-sm-3 col-form-label">ราคาปกติ :</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control form-control-sm" id="Price_full_Add" placeholder="ราคาปกติ">
                          </div>
                        </div>
                        <div class="form-group formmaginsetnone row">
                          <label for="Discount_Add" class="col-sm-3 col-form-label">ส่วนลด :</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control form-control-sm" id="Discount_Add" placeholder="ส่วนลด" onchange="onchange_discount_add(this);">
                          </div>
                        </div>
                        <div class="form-group formmaginsetnone row">
                          <label for="Remark_Add" class="col-sm-3 col-form-label">Remark :</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control form-control-sm" id="Remark_Add" placeholder="Remark">
                          </div>
                        </div>
                        <div class="form-group formmaginsetnone row">
                          <label for="Price_total_Add" class="col-sm-3 col-form-label">ยอดชำระ :</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control form-control-sm" id="Price_total_Add" placeholder="ยอดชำระ">
                          </div>
                        </div>
                      </form>
                      <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-4" align="center">
                          <button class="btn btn-sm btn-success" onclick="GenerateWiFi();">เพิ่มลูกค้า</button>
                        </div>
                        <div class="col-md-4" align="right">
                          <input type="hidden" id="id_card_add">
                          <input type="hidden" id="card_start_add">
                          <input type="hidden" id="card_end_add">
                          <input type="hidden" id="card_img_add">
                          <input type="hidden" id="gender">
                          <button class="btn btn-sm btn-danger" id="read_card" onclick="Getdatacard();" disabled><span id="read_card_text">Insert ID Card</span></button>
                        </div>
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

</body>
<!-- All Js -->
<script type="text/javascript" src="{{ url('js/app.js') }}"></script>
<!-- MainUsers -->
<script type="text/javascript" src="{{ url('js/MainUsers.js') }}"></script>
<!-- Checkin Js -->
<script type="text/javascript" src="{{ url('js/Checkin.js') }}"></script>
</html>
