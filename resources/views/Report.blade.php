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
    <style>
    .nav-pills .nav-link.tab_1.active, .nav-pills .show > .nav-link  {
        color: #fff;
        background-color: #87CEEB;
    }
    </style>
    <style media="print">
      @media screen {
      #printSection {
      display: none;
      }
      }
      @media print {
      body * {
      visibility:hidden;
      }
      #printSection, #printSection * {
      visibility:visible;
      }
      #printSection {
      position:absolute;
      left: 0;
      right: 0;
      top: 0;
      bottom: 0;
      }
    </style>
</head>

<body style="background-color: #ffffff;">
    @include('Head')
    <div class="card">
        <div class="card-header d-flex p-0">
            <h3 class="card-title p-3">รายงานการใช้บริการสมาชิก</h3>
            <ul class="nav nav-pills ml-auto p-2">
                <li class="nav-item"><a class="nav-link tab_1 active show" href="#tab_1" data-toggle="tab">สรุปจำนวนลูกค้าที่มาใช้บริการ</a></li>
                <li class="nav-item"><a class="nav-link tab_2" href="#tab_2" data-toggle="tab">สรุปจำนวนลูกค้าการใช้คลาส</a></li>
            </ul>
        </div><!-- /.card-header -->
        <div class="card-body" style="padding: 0.5rem;">
            <div class="tab-content">
                <div class="tab-pane active show" id="tab_1">
                    <div class="row">
                        <div class="col-md-12">
                          <form>
                            <div class="form-row align-items-center">
                              วันที่:
                              <div class="col-sm-2 my-1">
                                <div class="input-group">
                                  <input type="text" data-toggle="datepicker" data-date-format='dd/mm/yyyy' class="form-control form-control-sm" id="Tab_1_start" placeholder="เลือกวันที่">
                                  <div class="input-group-append">
                                    <button type="button" class="btn btn-sm btn-outline-secondary docs-datepicker-trigger" disabled="">
                                      <i class="fa fa-calendar" aria-hidden="true"></i>
                                    </button>
                                  </div>
                                </div>
                              </div>
                              ถึง:
                              <div class="col-sm-2 my-1">
                                <div class="input-group">
                                  <input type="text" data-toggle="datepicker" data-date-format='dd/mm/yyyy' class="form-control form-control-sm" id="Tab_1_end" placeholder="เลือกวันที่">
                                  <div class="input-group-append">
                                    <button type="button" class="btn btn-sm btn-outline-secondary docs-datepicker-trigger" disabled="">
                                      <i class="fa fa-calendar" aria-hidden="true"></i>
                                    </button>
                                  </div>
                                </div>
                              </div>
                              <div class="col-auto my-1">
                                <button type="button" class="btn btn-sm btn-primary" onclick="Showthb1();">ค้นหา</button>
                                <button type="button" class="btn btn-sm btn-success" onclick="printElement(document.getElementById('Print_Report1'));"><i class="fas fa-print"></i></button>
                              </div>
                            </div>
                          </form>
                          <hr>
                          <div id="Print_Report1" style="background-color: #ffffff;">
                          <div id="Tab1_Display"></div>
                          </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab_2">
                    <div class="row">
                        <div class="col-md-12">
                          <form>
                            <div class="form-row align-items-center">
                              วันที่:
                              <div class="col-sm-2 my-1">
                                <div class="input-group">
                                  <input type="text" data-toggle="datepicker" data-date-format='dd/mm/yyyy' class="form-control form-control-sm" id="Tab_2_start" placeholder="เลือกวันที่">
                                  <div class="input-group-append">
                                    <button type="button" class="btn btn-sm btn-outline-secondary docs-datepicker-trigger" disabled="">
                                      <i class="fa fa-calendar" aria-hidden="true"></i>
                                    </button>
                                  </div>
                                </div>
                              </div>
                              ถึง:
                              <div class="col-sm-2 my-1">
                                <div class="input-group">
                                  <input type="text" data-toggle="datepicker" data-date-format='dd/mm/yyyy' class="form-control form-control-sm" id="Tab_2_end" placeholder="เลือกวันที่">
                                  <div class="input-group-append">
                                    <button type="button" class="btn btn-sm btn-outline-secondary docs-datepicker-trigger" disabled="">
                                      <i class="fa fa-calendar" aria-hidden="true"></i>
                                    </button>
                                  </div>
                                </div>
                              </div>
                              <div class="col-auto my-1">
                                <button type="button" class="btn btn-sm btn-primary" onclick="Showthb2();">ค้นหา</button>
                                <button type="button" class="btn btn-sm btn-success" onclick="printElement(document.getElementById('Print_Report2'));"><i class="fas fa-print"></i></button>
                              </div>
                              <div class="col-auto my-1">
                                <select class="custom-select custom-select-sm" id="Tab_2_select">
                                  <option selected value="0">เลือกประเภทการแสดง</option>
                                  <option value="1">ค้นหาตามชื่อคลาส</option>
                                  <option value="2">ค้นหาตามคลาส</option>
                                  <option value="3">ค้นหาตามชื่อเทรนเนอร์</option>
                                </select>
                              </div>
                            </div>
                          </form>
                          <hr>
                          <div id="Print_Report2" style="background-color: #ffffff;">
                          <div id="Tab2_Display"></div>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.tab-content -->
        </div><!-- /.card-body -->
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
                    <h5 class="modal-title" id="Find_the_name_Label">ค้นหาชื่อ</h5>
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
<!-- Dashboard -->
<script type="text/javascript" src="{{ url('js/dashboard.js') }}"></script>
<!-- Report -->
<script type="text/javascript" src="{{ url('js/Report.js') }}"></script>
<!-- Welcome Js -->
<script type="text/javascript" src="{{ url('js/welcome.js') }}"></script>
<!-- Checkin Js -->
<script type="text/javascript" src="{{ url('js/Checkin.js') }}"></script>
<!-- Use Script -->
<script type="text/javascript">
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
        $('[data-toggle="datepicker"]').datepicker({
          language: 'en',
          autoClose: true,
        });
    });
</script>

</html>
