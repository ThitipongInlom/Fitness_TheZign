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
                    <div class="card-body">
                        <div class="clearfix">
                            <div class="float-left">
                                <form class="form-inline" action="{{ url('/CheckIn') }}" method="post" accept-charset="utf-8">
                                    @csrf
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">Code</span>
                                        </div>
                                        <input type="text" id="inputcode" class="form-control" name="inputcode" placeholder="Code" @if(empty($_POST)) autofocus @endif>
                                            &nbsp;&nbsp;&nbsp;
                                            <button type="submit" class="btn btn-outline-primary" data-toggle="tooltip" data-placement="bottom" title="ค้นหา"><i class="fas fa-search"></i></button>
                                            &nbsp;&nbsp;&nbsp;
                                            <button type="button" class="btn btn-outline-info" data-toggle="tooltip" data-placement="bottom" title="สแกน Barcode"><i class="fas fa-barcode"></i></button>
                                    </div>
                                </form>
                            </div>
                            <div class="float-right">
                                <a href="{{ url('Dashboard') }}" class="btn btn-outline-danger" role="button" aria-pressed="true" data-toggle="tooltip" data-placement="bottom" title="ย้อนกลับหน้า เลือก รายการ"><i class="fas fa-arrow-left"></i></a>
                                @if (empty($_POST))
                                @else
                                <button class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="ประวัติย้อนหลัง" onclick="History();">ประวัติย้อนหลัง</button>
                                @endif
                                <button class="btn btn-primary" onclick="Find_the_name_Modal();" data-toggle="tooltip" data-placement="bottom" title="ค้นหารายชื่อลูกค้า">ค้นหาชื่อ</button>
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
                    <div class="card-body">
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
                    <div class="card-body">
                        <div id="PackageOnuseDisplay"></div>
                        <div id="DisplayItemList"></div>
                    </div>
                </div>
            </div>
            <!-- Col 4 -->
            <div class="col-md-4">
                <!-- Img -->
                <div class="card card-info card-outline">
                    <div class="card-body">
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
                    <div class="card-body">
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
                        <div class="card-body">
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
                            <input type="text" class="form-control" name="namesearching" id="namesearching" placeholder="ค้นหาชื่อลูกค้า" onkeypress="if (event.keyCode==13){ searchingname(this);return false;}">
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-outline-primary" onclick="searchinguse();">ใช้งาน</button>
                            <button class="btn btn-outline-success" onclick="searchingall();">ทั้งหมด</button>
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
                <div class="modal-header bg-primary">
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
                <div class="modal-header bg-primary">
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
                <div class="modal-header bg-primary">
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
                <div class="modal-header bg-primary">
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
                <div class="modal-header bg-danger">
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
                <div class="modal-header bg-primary">
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
                <div class="modal-header bg-primary">
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

</body>
<!-- All Js -->
<script type="text/javascript" src="{{ url('js/app.js') }}"></script>
<!-- Checkin Js -->
<script type="text/javascript" src="{{ url('js/Checkin.js') }}"></script>

</html>
