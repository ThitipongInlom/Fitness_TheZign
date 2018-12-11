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
    <style>
      body{
        font-size: 12px;
      }
    </style>
</head>

<body class="login-page">
    @include('Head')
    <div class="container">
        <!-- Head Code Input -->
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-body" style="padding: 0.5rem;">
                        <div class="clearfix">
                            <div class="float-left">
                            </div>
                            <div class="float-right">
                                @if (empty($_POST))
                                @else
                                <button class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="bottom" title="ประวัติย้อนหลัง" onclick="History();">ประวัติย้อนหลัง</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Not Have Post -->
        @if (empty($_POST))
        @else
        <!-- Have Post -->
        @if ($CheckNum == '1')
        <!-- Have Data -->
        @if ($CheckStatus == '1')
        <!-- User Have Live -->
        <div class="row">
            <!-- Col 8 -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body" style="padding: 0.5rem;">
                        <table class="table table-striped table-sm">
                            <tbody>
                                @foreach ($Data as $user)
                                <input type="hidden" id="codehidden" value="{{ $user->code }}">
                                <tr class="bg-info" align="center">
                                    <td><b>ชื่อ-นามสกุล:</b></td>
                                    <td>{{ $user->name }}</td>
                                    <td><b>Code:</b></td>
                                    <td>{{ $user->code }}</td>
                                    <td><b>Phone:</b></td>
                                    <td>{{ $user->phone }}</td>
                                </tr>
                                <tr class="bg-info" align="center">
                                    <td><b>User WiFi:</b></td>
                                    <td>{{ $user->wifiusername }}</td>
                                    <td><b>Pass Wifi:</b></td>
                                    <td>{{ $user->wifipassword }}</td>
                                    <td><b>ประเภท:</b></td>
                                    <td>{{ $user->type }}</td>
                                </tr>
                                <tr class="bg-info" align="center">
                                    <td><b>วันที่เริ่มใช้งาน:</b></td>
                                    <td>{{ date('d/m/Y', strtotime($user->start)) }}</td>
                                    <td><b>วันที่สิ้นสุดใช้งาน:</b></td>
                                    <td>{{ date('d/m/Y', strtotime($user->expire)) }}</td>
                                    <td><b>วันเกิด</b></td>
                                    <td>
                                        @if ($user->birthday == '0000-00-00' OR $user->birthday == '1970-01-01') {{ '-' }}
                                        @else {{ date('d/m/Y', strtotime($user->birthday)) }}
                                        @endif</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- DisplayPackage -->
                        <div id="DisplayPackage"></div>
                    </div>
                </div>
                <!-- DisplatItemList -->
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h3 class="card-title">รายการต่างๆ</h3>
                        <div class="card-tools">
                          <button type="button" class="btn btn-sm btn-danger" onclick="history.go(0)">
                            หากไม่มีรายการขึ้น คลิ้ก
                          </button>
                        </div>
                    </div>
                    <div class="card-body" style="padding: 0.5rem;">
                        <div id="PackageOnuseDisplay"></div>
                        <div id="DisplayItemList"></div>
                    </div>
                </div>
            </div>
            <!-- Col 4 -->
            <div class="col-md-4">
                <!-- Img -->
                <div class="card card-info card-outline">
                    <div class="card-body" style="padding: 0.5rem;">
                        <div align="center">
                        @if ($user->Img != '')
                        <img src='./img/{{ $user->Img }}' alt='Img' width="200" height="200" class='img-thumbnail'>
                        @else
                        <img src='./img/default.svg' alt='Img' width="200" height="200" class='img-thumbnail'>
                        @endif
                        </div>
                    </div>
                </div>
                <!-- Package -->
                <div id="PackageItem"></div>
                <!-- Item -->
                <div class="card card-info card-outline">
                    <div class="card-body" style="padding: 0.5rem;">
                        <div id="PaneItem"></div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <!-- User Have End -->
        <div class="row">
            <div class="col-md-12">
                <div align="center">
                    <h4 style="color: red;"><b>สถานะ:</b> หมดอายุ</h4>
                    <div class="card">
                        <div class="card-body" style="padding: 0.5rem;">
                            <table class="table table-striped table-sm">
                                <tbody>
                                    @foreach ($Data as $user)
                                    <input type="hidden" id="codehidden" value="{{ $user->code }}">
                                    <tr class="bg-info" align="center">
                                        <td><b>ชื่อ-นามสกุล:</b></td>
                                        <td>{{ $user->name }}</td>
                                        <td><b>Code:</b></td>
                                        <td>{{ $user->code }}</td>
                                        <td><b>Phone:</b></td>
                                        <td>{{ $user->phone }}</td>
                                    </tr>
                                    <tr class="bg-info" align="center">
                                        <td><b>User WiFi:</b></td>
                                        <td>{{ $user->wifiusername }}</td>
                                        <td><b>Pass Wifi:</b></td>
                                        <td>{{ $user->wifipassword }}</td>
                                        <td><b>ประเภท:</b></td>
                                        <td>{{ $user->type }}</td>
                                    </tr>
                                    <tr class="bg-info" align="center">
                                        <td><b>วันที่เริ่มใช้งาน:</b></td>
                                        <td>{{ date('d-m-Y', strtotime($user->start)) }}</td>
                                        <td><b>วันที่สิ้นสุดใช้งาน:</b></td>
                                        <td>{{ date('d-m-Y', strtotime($user->expire)) }}</td>
                                        <td><b>วันเกิด</b></td>
                                        <td>
                                            @if ($user->birthday == '0000-00-00' OR $user->birthday == '1970-01-01') {{ '-' }}
                                            @else {{ date('d-m-Y', strtotime($user->birthday)) }}
                                            @endif</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr>
                    <a class="btn btn-danger" href="{{ url('/Dashboard') }}" role="button" data-toggle="tooltip" data-placement="bottom" title="MainCheck">ย้อนกลับ</a>
                </div>
            </div>
        </div>
        @endif
        <!-- End User Have End -->
        @elseif ($CheckNum == '0')
        <!-- Not Have Data -->
        <div class="row">
            <div class="col-md-12">
                <div align="center">
                    <h3>ไม่พบข้อมูล</h3>
                    <hr>
                    <a class="btn btn-danger" href="{{ url('/Dashboard') }}" role="button" data-toggle="tooltip" data-placement="bottom" title="MainCheck">ย้อนกลับ</a>
                </div>
            </div>
        </div>
        @endif
        @endif
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
                            <input type="text" class="form-control" name="namesearching" id="namesearching" placeholder="ค้นหาชื่อลูกค้า" onkeypress="if (event.keyCode==13){ searchingname(this);return false;}">
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
    <div class="modal fade" id="Edit_Number" tabindex="-1" role="dialog" aria-labelledby="Edit_Number_Label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary" style="padding: 0.7rem;">
                    <h5 class="modal-title" id="Edit_Number_Label">แก้ไขจำนวนสินค้า</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="edit_number_display"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="Edit_Number_Key" tabindex="-1" role="dialog" aria-labelledby="Edit_Number_Label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary" style="padding: 0.7rem;">
                    <h5 class="modal-title" id="Edit_Number_Label">แก้ไขหมายเลข กุญแจ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="edit_number_display_key"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="History" tabindex="-1" role="dialog" aria-labelledby="History_Label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary" style="padding: 0.7rem;">
                    <h5 class="modal-title" id="History_Label">ประวัติย้อนหลัง 5ครั้ง ล่าสุด</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="History_display"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="Modal_History_Package_Useing" tabindex="-1" role="dialog" aria-labelledby="History_Label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary" style="padding: 0.7rem;">
                    <h5 class="modal-title" id="History_Label">ประวัติการใช้งาน Package</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="Modal_History_Package_Useing_Display"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="Alertmodalcheckprice" tabindex="-1" role="dialog" aria-labelledby="History_Label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger" style="padding: 0.7rem;">
                    <h5 class="modal-title" id="History_Label">แจ้งเตือน</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div align="center">
                      <h2 style="color:red;">จำนวนเงินที่ต้องชำระ</h2><br>
                      <div id="displayalertprice"></div><br>
                      <div id="btnLogoutQuery"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="VoidItem_modal" tabindex="-1" role="dialog" aria-labelledby="History_Label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary" style="padding: 0.7rem;">
                    <h5 class="modal-title">เช็ค Void Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div align="center">
                        <div id="Voiditem_Display"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="Charge_modal" tabindex="-1" role="dialog" aria-labelledby="Charge_modal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary" style="padding: 0.7rem;">
                    <h5 class="modal-title">เช็ค Charge Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div align="center">
                        <div id="Charge_Display"></div>
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
                          ค้นหารายชื่อลูกค้าTheZign
                      </div>
                      <div class="col-md-4">
                          <input type="text" class="form-control form-control-sm" name="namesearching" id="namesearchingthezign" placeholder="ค้นหารายชื่อลูกค้าTheZign" onkeypress="if (event.keyCode==13){ Airlink_modal_data(this);return false;}">
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
<!-- Checkin Js -->
<script type="text/javascript" src="{{ url('js/Checkin.js') }}"></script>

</html>
