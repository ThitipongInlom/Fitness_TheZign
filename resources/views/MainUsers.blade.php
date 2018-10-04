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
    </style>
</head>

<body>
    @include('Head')
    <div align="center">
        <table class="table table-sm row-border table-striped table-bordered table-hover TableDisplay" cellspacing="0" cellpadding="0" id="TableDisplay">
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
</body>
<!-- All Js -->
<script type="text/javascript" src="{{ url('js/app.js') }}"></script>
<!-- MainUsers -->
<script type="text/javascript" src="{{ url('js/MainUsers.js') }}"></script>


</html>
