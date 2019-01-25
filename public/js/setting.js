// Show Tab 1
$('#tab1').on('show.bs.collapse', function () {
    $("#btn_tab1").addClass('active');
    $("#ShowAdd").hide();
    console.log('Teb 1 Show');
});
// Hide Tab 1
$('#tab1').on('hide.bs.collapse', function () {
    $("#btn_tab1").removeClass('active');
});
// Show Tab2
$('#tab2').on('show.bs.collapse', function () {
    $("#btn_tab2").addClass('active');
    $("#ShowAdd").hide();
    console.log('Teb 2 Show');
});
// Show Tab2
$('#tab2').on('hide.bs.collapse', function () {
    $("#btn_tab2").removeClass('active');
});

var Edit_Type = function Edit_Type(e) {
    // Show Modal
    $("#Edit_Type").modal('show');
    $("body").css("padding-right", "0");
    console.log(e);
}

// Table Tab1
$.fn.dataTable.ext.errMode = 'throw';
var Table_tab1 = $('#Table_tab1').DataTable({
    "dom": "<'row'<'col-sm-1'l><'col-sm-7'><'col-sm-4'>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-1'i><'col-sm-7'><'col-sm-4'p>>",
    "processing": true,
    "serverSide": true,
    "bPaginate": true,
    "responsive": true,
    "aLengthMenu": [
        [8, 25, 50, -1],
        ["8", "25", "50", "ทั้งหมด"]
    ],
    "ajax": {
        "url": 'Table_tab_1',
        "type": 'POST',
        "headers": {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        /*
        data: function (d) {
            d.searchingcode = $("#searchingcode").val();
            d.searchingselect = $("#searchingselect").val();
        }
        */
    },
    "columns": [{
            "data": 'type_code',
            "name": 'type_code',
        },
        {
            "data": 'type_value',
            "name": 'type_value'
        },
        {
            "data": 'type_day',
            "name": 'type_day'
        },
        {
            "data": 'type_month',
            "name": 'type_month'
        },
        {
            "data": 'type_year',
            "name": 'type_year'
        },
        {
            "data": 'type_price',
            "name": 'type_price'
        },
        {
            "data": 'type_commitment',
            "name": 'type_commitment'
        },
        {
            "data": 'action',
            "name": 'action',
        },
    ],
    "columnDefs": [{
            "className": 'text-left',
            "targets": [0,1]
        },
        {
            "className": 'text-center',
            "targets": [7]
        },
        {
            "className": 'text-right',
            "targets": [2,3,4,5,6]
        },
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
