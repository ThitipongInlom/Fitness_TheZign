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
</head>

<body>
    @include('Head')
    <div class="row">
        <div class="col-md-4">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">รายชื่อลูกค้าที่ยังใช้บริการ</h3>
                    <div class="card-tools">
                        <a href="{{ url('MainCheck') }}" class="btn btn-tool" role="button" aria-pressed="true" data-toggle="tooltip" data-placement="left" title="ย้อนกลับหน้า เลือก รายการ"><i class="fas fa-arrow-left"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <div id="Tableonlineforlogout"></div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">เมนูเช็คเอาท์</h3>
                    <div class="card-tools">
                        <i class="fas fa-2x fa-globe-africa" data-toggle="tooltip" data-placement="left" title="รายการเช็คเอาท์"></i>
                    </div>
                </div>
                <div class="card-body">
                    <div id="Showdatatologout">
                        <div class="row">
                            <div class="col-md-12">
                                <div align="center">
                                    <h4 style="color: red;">กรุณาเลือกลูกค้าจากด้านซ้าย</h4>
                                </div>
                            </div>
                        </div>
                    </div>
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

</body>
<!-- All Js -->
<script type="text/javascript" src="{{ url('js/app.js') }}"></script>
<!-- Checkout Js -->
<script type="text/javascript" src="{{ url('js/Checkout.js') }}"></script>

</html>
