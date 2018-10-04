$(document).ready(function() {
    LoadTable();
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
      }, 600);
      return false;
  });
}

var LoadTable = function LoadTable() {
  var csrf = $('meta[name="csrf-token"]').attr('content');
  $('#TableDisplay').DataTable({
    "dom":
      "<'row'<'col-sm-1'l><'col-sm-7'><'col-sm-4'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-1'i><'col-sm-7'><'col-sm-4'p>>",
      "processing": true,
      "serverSide": true,
      "bPaginate": true,
      "responsive": true,
      "aLengthMenu": [[ 10, 50, 100, -1], [ "10","50","100","ทั้งหมด"]],
      "ajax": {
        "url": 'DataTable',
        "type": 'POST',
        "data": {
            '_token': csrf
        }
      },
      "columns": [
          {"data": 'code', "name": 'code'},
          {"data": 'wifipassword', "name": 'wifipassword'},
          {"data": 'name', "name": 'name'},
          {"data": 'start', "name": 'start'},
          {"data": 'expire', "name": 'expire'},
          {"data": 'birthday', "name": 'birthday'},
          {"data": 'phone', "name": 'phone'},
          {"data": 'type', "name": 'type'},
          {"data": 'address', "name": 'address'},
          {"data": 'status', "name": 'status'},
          {"data": 'user_seting', "name": 'user_seting'},
          {"data": 'action', "name": 'action', "orderable": false, "searchable": false},
      ],
      "language": {
      "lengthMenu":"แสดง _MENU_ คน",
      "search":"ค้นหา:",
      "info":"แสดง _START_ ถึง _END_ ทั้งหมด _TOTAL_ คน",
      "infoEmpty":"แสดง 0 ถึง 0 ทั้งหมด 0 คน",
      "infoFiltered":"(จาก ทั้งหมด _MAX_ ทั้งหมด คน)",
      "processing": "กำลังโหลดข้อมูล...",
      "zeroRecords": "ไม่มีข้อมูล",
      "paginate": {
      "first": "หน้าแรก",
      "last": "หน้าสุดท้าย",
      "next": "ต่อไป",
      "previous": "ย้อนกลับ"
      },
      },
      "bSort": false,
  });
}
