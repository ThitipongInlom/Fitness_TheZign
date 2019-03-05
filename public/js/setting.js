// Show Tab 1
$('#tab1').on('show.bs.collapse', function () {
    $("#btn_tab1").addClass('active');
    $("#ShowAdd").hide();
    console.log('Teb 1 Show');
});
// Hide Tab 1
$('#tab1').on('hide.bs.collapse', function () {
    $("#btn_tab1").removeClass('active');
    console.log('Teb 1 Hide');
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
    console.log('Teb 2 Hide');
});

var Edit_Type = function Edit_Type(e) {
    // Show Modal
    $("#Edit_Type").modal('show');
    $("body").css("padding-right", "0");
    var Data = new FormData();
    Data.append('type_id', e);
    $.ajax({
        url: 'Get_type_data',
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: 'text',
        cache: false,
        contentType: false,
        processData: false,
        data: Data,
        success: function (callback) {
            var res = jQuery.parseJSON(callback);
            $("#hidden_type_id").val(res.type_id);
            $("#edit_type_code").val(res.type_code);
            $("#edit_type_name").val(res.type_value);
            $("#edit_type_commitment").val(res.type_commitment);
            $("#edit_type_day").val(res.type_day);
            $("#edit_type_month").val(res.type_month);
            $("#edit_type_year").val(res.type_year);
            $("#edit_price").val(res.type_price);
        }
    });
}

var Add_type = function Add_type() {
    // Show Modal
    $("#Add_type").modal('show');
    $("body").css("padding-right", "0");
}

$('#Add_type').on('hidden.bs.modal', function (e) {
    $("#add_type_code").val('');
    $("#add_type_name").val('');
    $("#add_type_commitment").val('0');
    $("#add_type_day").val('0');
    $("#add_type_month").val('0');
    $("#add_type_year").val('0');
    $("#add_price").val('');
})

var Save_Add_Data = function Save_Add_Data() {
    if ($("#add_type_code").val() == '') {
        alert('กรุณา กรอก Code');
        $("#add_type_code").focus();
    } else if ($("#add_type_name").val() == '') {
        alert('กรุณา กรอก Name');
        $("#add_type_name").focus();
    } else if ($("#add_price").val() == '') {
        alert('กรุณา กรอก Price');
        $("#add_price").focus();
    }else{
    //Add Data To Form
    var Data = new FormData();
    Data.append('add_type_code', $("#add_type_code").val());
    Data.append('add_type_name', $("#add_type_name").val());
    Data.append('add_type_commitment', $("#add_type_commitment").val());
    Data.append('add_type_day', $("#add_type_day").val());
    Data.append('add_type_month', $("#add_type_month").val());
    Data.append('add_type_year', $("#add_type_year").val());
    Data.append('add_price', $("#add_price").val());
    $.ajax({
        url: 'Add_Data_Type',
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: 'text',
        cache: false,
        contentType: false,
        processData: false,
        data: Data,
        success: function (callback) {
            if (callback == 'OK') {
                $("#Add_type").modal('hide');
                Table_tab1.draw();
            }
        }
    });
    }
}

var Save_Edit_Data = function Save_Edit_Data() {
    if ($("#edit_type_code").val() == '') {
        alert('กรุณา กรอก Code');
        $("#edit_type_code").focus();
    } else if ($("#edit_type_name").val() == '') {
        alert('กรุณา กรอก Name');
        $("#edit_type_name").focus();
    } else if ($("#edit_price").val() == '') {
        alert('กรุณา กรอก Price');
        $("#edit_price").focus();
    } else {
        //Add Data To Form
        var Data = new FormData();
        Data.append('edit_id', $("#hidden_type_id").val());
        Data.append('edit_type_code', $("#edit_type_code").val());
        Data.append('edit_type_name', $("#edit_type_name").val());
        Data.append('edit_type_commitment', $("#edit_type_commitment").val());
        Data.append('edit_type_day', $("#edit_type_day").val());
        Data.append('edit_type_month', $("#edit_type_month").val());
        Data.append('edit_type_year', $("#edit_type_year").val());
        Data.append('edit_price', $("#edit_price").val());
        $.ajax({
            url: 'Edit_Data_Type',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'text',
            cache: false,
            contentType: false,
            processData: false,
            data: Data,
            success: function (callback) {
                if (callback == 'OK') {
                    $("#Edit_Type").modal('hide');
                    Table_tab1.draw();
                }
            }
        });
    }
}

// Table Tab1
$.fn.dataTable.ext.errMode = 'throw';
var Table_tab1 = $('#Table_tab1').DataTable({
    "dom": "<'row'<'col-sm-1'><'col-sm-7'><'col-sm-4'>>" +
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
