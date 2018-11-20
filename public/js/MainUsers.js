$(document).ready(function() {
    Backtotop();
});

var Backtotop = function Backtotop() {
    $('body').append('<div id="toTop" class="btn btn-outline-primary"><i class="fas fa-arrow-up"></i> ขึ้นบน</div>');
    $(window).scroll(function() {
        if ($(this).scrollTop() != 0) {
            $('#toTop').fadeIn();
        } else {
            $('#toTop').fadeOut();
        }
    });
    $('#toTop').click(function() {
        $("html, body").animate({
            scrollTop: 0
        }, 800);
        return false;
    });
}

var csrf = $('meta[name="csrf-token"]').attr('content');
var TableDisplay = $('#TableDisplay').DataTable({
    "dom": "<'row'<'col-sm-1'l><'col-sm-7'><'col-sm-4'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-1'i><'col-sm-7'><'col-sm-4'p>>",
    "processing": true,
    "serverSide": true,
    "bPaginate": true,
    "responsive": true,
    "aLengthMenu": [
        [10, 50, 100, -1],
        ["10", "50", "100", "ทั้งหมด"]
    ],
    "ajax": {
        "url": 'DataTable',
        "type": 'POST',
         data: function (d) {
            d._token = csrf;
            d.searchingcode = $("#searchingcode").val();
            d.searchingselect = $("#searchingselect").val();
        }
    },
    "columns": [{
            "data": 'code',
            "name": 'code',
        },
        {
            "data": 'wifipassword',
            "name": 'wifipassword'
        },
        {
            "data": 'name',
            "name": 'name'
        },
        {
            "data": 'start',
            "name": 'start'
        },
        {
            "data": 'expire',
            "name": 'expire'
        },
        {
            "data": 'birthday',
            "name": 'birthday'
        },
        {
            "data": 'phone',
            "name": 'phone'
        },
        {
            "data": 'type',
            "name": 'type'
        },
        {
            "data": 'address',
            "name": 'address'
        },
        {
            "data": 'status',
            "name": 'status'
        },
        {
            "data": 'user_seting',
            "name": 'user_seting'
        },
        {
            "data": 'action',
            "name": 'action',
            "orderable": false,
            "searchable": false
        },
    ],
    "columnDefs": [
    {"className": "dt-center", "targets": "_all"}
    ],
    "language": {
        "lengthMenu": "แสดง _MENU_ คน",
        "search": "ค้นหา:",
        "info": "แสดง _START_ ถึง _END_ ทั้งหมด _TOTAL_ คน",
        "infoEmpty": "แสดง 0 ถึง 0 ทั้งหมด 0 คน",
        "infoFiltered": "(จาก ทั้งหมด _MAX_ ทั้งหมด คน)",
        "processing": "กำลังโหลดข้อมูล...",
        "zeroRecords": "ไม่มีข้อมูล",
        "paginate": {
            "first": "หน้าแรก",
            "last": "หน้าสุดท้าย",
            "next": "ต่อไป",
            "previous": "ย้อนกลับ"
        },
    },
    search: {
    "regex": true
    },
});

$('#searchTableDisplay').on('click', function(e) {
    TableDisplay.draw();
    e.preventDefault();
});

var AddUsermodel = function AddUsermodel() {
    // Show Modal
    $("#AddUsermodel").modal('show');
    $("body").css("padding-right", "0");
}

var ViewData = function ViewData(e) {
    // Show Modal
    $("#ViewDataUser").modal('show');
    $("body").css("padding-right", "0");
    var id = $(e).attr('id');
    // Create From Data
    var Data = new FormData();
    console.log(e);
    // Data Put Array
    Data.append('id', id);
    $.ajax({
        url: 'ViewData',
        type: 'POST',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: 'text',
        cache: false,
        contentType: false,
        processData: false,
        data: Data,
        success: function(callback) {
            var res = jQuery.parseJSON(callback);
            $("#ViewDataUserDisplay").html(res.Table);
            // IF Click Change
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
              if (e.target.hash == '#nav-contact') {
                  var TableDisplayDetail = $('#TableDisplayDetail').DataTable({
                      "dom": "<'row'<'col-sm-1'><'col-sm-7'><'col-sm-4'f>>" +
                             "<'row'<'col-sm-12'tr>>" +
                             "<'row'<'col-sm-1'i><'col-sm-7'><'col-sm-4'p>>",
                      "processing": true,
                      "serverSide": true,
                      "searching": false,
                      "responsive": true,
                      "ordering": false,
                      "bDestroy": true,
                      "lengthMenu": [[5,], [5,]],
                      "ajax": {
                          "url": 'Model_code_viewdata',
                          "type": 'POST',
                           data: function (d) {
                              d._token = csrf;
                              d.model_code_viewdata = $("#model_code_viewdata").val();
                          }
                      },
                      "columns": [{
                              "data": 'name',
                              "name": 'name',
                          },
                          {
                              "data": 'start',
                              "name": 'start'
                          },
                          {
                              "data": 'expire',
                              "name": 'expire'
                          },
                          {
                              "data": 'typestatus',
                              "name": 'typestatus'
                          },
                          {
                              "data": 'fullprice',
                              "name": 'fullprice'
                          },
                          {
                              "data": 'alldis',
                              "name": 'alldis'
                          },
                          {
                              "data": 'resultprice',
                              "name": 'resultprice'
                          },
                      ],
                      "columnDefs": [
                      {"className": "dt-center", "targets": "_all"}
                      ],
                      "language": {
                          "lengthMenu": "แสดง _MENU_ รายการ",
                          "search": "ค้นหา:",
                          "info": "แสดง _START_ ถึง _END_ ทั้งหมด _TOTAL_ รายการ",
                          "infoEmpty": "แสดง 0 ถึง 0 ทั้งหมด 0 รายการ",
                          "infoFiltered": "(จาก ทั้งหมด _MAX_ ทั้งหมด รายการ)",
                          "processing": "กำลังโหลดข้อมูล...",
                          "zeroRecords": "ไม่มีข้อมูล",
                          "paginate": {
                              "first": "หน้าแรก",
                              "last": "หน้าสุดท้าย",
                              "next": "ต่อไป",
                              "previous": "ย้อนกลับ"
                          },
                      },
                      search: {
                      "regex": true
                      },
                  });
              }
            });
        }
    });
}

// Upload Img User
var uploadimguser = function uploadimguser(e) {
    var Img = $("#imguploadfile").prop('files')[0];
    var User_Id = $(e).attr('user_id');
    var Code = $(e).attr('code');
    // Create From Data
    var Data = new FormData();
    // Data Put Array
    Data.append('Img', Img);
    Data.append('User_Id', User_Id);
    Data.append('Code', Code);
    $.ajax({
        url: 'Uploadimguser',
        type: 'POST',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: 'text',
        cache: false,
        contentType: false,
        processData: false,
        data: Data,
        success: function(callback) {
            var res = jQuery.parseJSON(callback);
            var User_Id = '<div id="'+res.text+'"></div>';
            $("#ViewDataUser").modal('hide');
            setTimeout(function () {
              ViewData(User_Id);
            }, 500);
        }
    });
}