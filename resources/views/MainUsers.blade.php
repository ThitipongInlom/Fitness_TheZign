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
    </style>
</head>
<body>
    @include('Head')
    <div class="card">
        <div class="card-body">
            <div class="row">
              <div class="col-md-2">
                <input type="text" id="searchingcode" class="form-control" placeholder="ค้นหา Code">
              </div>
              <div class="col-md-2">
                <select class="custom-select" id="searchingselect">
                  <option selected value="All">ค้นหาลูกค้าทั้งหมด</option>
                  <option value="Active">ค้าหาลูกค้า Active</option>
                  <option value="Expired">ค้าหาลูกค้า Expired</option>
                </select>
              </div>
              <div class="col-md-7">
                  <button class="btn btn-primary" type="submit" id="searchTableDisplay">ค้าหา</button>
              </div>
              <div class="col-md-1">
                  <button class=" btn btn-success" type="btton" onclick="AddUsermodel();">เพิ่มลูกค้า</button>
              </div>
            </div>
            <hr>
            <div class="row">
            <div class="col-md-12">
            <div class="table-responsive">
            <table class="table table-sm dt-responsive nowrap  row-border table-bordered table-hover TableDisplay" cellspacing="0" cellpadding="0" id="TableDisplay">
                <thead>
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
                <div class="modal-header bg-primary">
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
                <div class="modal-header bg-primary">
                    <h5 class="modal-title">เพิ่มลูกค้า</h5>
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

</body>
<!-- All Js -->
<script type="text/javascript" src="{{ url('js/app.js') }}"></script>
<!-- MainUsers -->
<script type="text/javascript" src="{{ url('js/MainUsers.js') }}"></script>


</html>
