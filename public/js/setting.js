// Show Tab 1
$('#tab1').on('show.bs.collapse', function () {
    $("#btn_tab1").addClass('active');
    $("#ShowAdd").hide();
});
// Hide Tab 1
$('#tab1').on('hide.bs.collapse', function () {
    $("#btn_tab1").removeClass('active');
});
// Show Tab2
$('#tab2').on('show.bs.collapse', function () {
    $("#btn_tab2").addClass('active');
    $("#ShowAdd").hide();
});
// Show Tab2
$('#tab2').on('hide.bs.collapse', function () {
    $("#btn_tab2").removeClass('active');
});
// Show Tab3
$('#tab3').on('show.bs.collapse', function () {
    $("#btn_tab3").addClass('active');
    $("#ShowAdd").hide();
});
// Show Tab3
$('#tab3').on('hide.bs.collapse', function () {
    $("#btn_tab3").removeClass('active');
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
            $("#edit_free_sum_package").val(res.type_pt_free);
        }
    });
}

var Edit_Trainner_emp = function Edit_Trainner_emp(e) {
    // Show Modal
    $("#Edit_Trainner_emp").modal('show');
    $("body").css("padding-right", "0");
    var Data = new FormData();
    Data.append('tn_emp_id', e);
    $.ajax({
        url: 'Get_Trainner_emp_data',
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
            $("#hidden_trainner_emp_id").val(res.tn_emp_id);
            $("#firstname_trainner_edit").val(res.fname);
            $("#lastname_trainner_edit").val(res.lname);
            $("#classname_trainner_edit").val(res.status_emp);
        }
    });
}

var Add_type = function Add_type() {
    // Show Modal
    $("#Add_type").modal('show');
    $("body").css("padding-right", "0");
}

var Add_trainner_emp = function Add_trainner_emp() {
    // โชว์ Modal Add_trainner_emp
    $("#Add_trainner_emp").modal('show');
    $("body").css("padding-right", "0");
}

var Add_trainner = function Add_trainner() {
    // โชว์ Modal Add_trainner
    $("#Add_trainner").modal('show');
    $("body").css("padding-right", "0");
    // Select Trianner emp
    $.ajax({
        url: 'Select_trianner_emp',
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (callback) {
            var res = jQuery.parseJSON(callback);
            $("#select_trianner_emp").html(res.trainner_emp);
            $("#select_trainner_class").html(res.type_class);
            $('.only-time').datepicker({
                dateFormat: ' ',
                timepicker: true,
                classes: 'only-timepicker'
            });
        }
    });
    // Select Trianner class
}

var Edit_trainner = function Edit_trainner(e) {
    var trainner_id = $(e).attr('id');
    // โชว์ Modal Edit_trainner
    $("#Edit_trainner").modal('show');
    $("body").css("padding-right", "0");
    $('.only-time').datepicker({
        dateFormat: ' ',
        timepicker: true,
        classes: 'only-timepicker'
    });
    //Add Data To Form
    var Data = new FormData();
    Data.append('trainner_id', trainner_id);
    $.ajax({
        url: 'Get_data_trainner',
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
            $("#select_trianner_emp_edit").html(res.trainner_emp);
            $("#select_trainner_class_edit").html(res.type_class);
            $("input[name=exampleRadios_edit][value=" + res.radio_select + "]").attr('checked', 'checked');
            $("#input_trainner_time_start_edit").val(res.Data.train_time_start);
            $("#input_trainner_time_end_edit").val(res.Data.train_time_end);
        }
    });
}

$('#Edit_trainner').on('hidden.bs.modal', function (e) {
    $('[name="exampleRadios_edit"]').removeAttr('checked');
});

$('#Add_type').on('hidden.bs.modal', function (e) {
    $("#add_type_code").val('');
    $("#add_type_name").val('');
    $("#add_type_commitment").val('0');
    $("#add_type_day").val('0');
    $("#add_type_month").val('0');
    $("#add_type_year").val('0');
    $("#add_price").val('');
});

var Save_trainner = function Save_trainner() {
    var select_trainner_emp_add = $("#select_trainner_emp_add").val();
    var date_trainner_add = $('#date_trainner_add').val();
    var select_trainner_class_add = $("#select_trainner_class_add").val();
    var input_trainner_time_start = $("#input_trainner_time_start").val();
    var input_trainner_time_end = $("#input_trainner_time_end").val();
    var radioValue = $("input[name='exampleRadios']:checked").val();
    // เช็ค ค่าว่าง ในแต่ล่ะ ฟิว
    if (select_trainner_emp_add == '') {
        alert("เลือกผู้สอน เทรนเนอร์");
        $("#select_trainner_emp_add").focus();
    } else if (date_trainner_add == '') {
        alert("เลือก วันที่ จะสอน ");
        $("#date_trainner_add").focus();
    } else if (select_trainner_class_add == '') {
        alert("เลือก คลาสที่จะสอน");
        $("#select_trainner_class_add").focus();
    } else if (input_trainner_time_start == '') {
        alert("เลือกเวลาที่เริ่มสอน");
        $("#input_trainner_time_start").focus();
    } else if (input_trainner_time_end == '') {
        alert("เลือกเวลาที่สอนสิ้นสุด");
        $("#input_trainner_time_end").focus();
    } else {
        //Add Data To Form
        var Data = new FormData();
        Data.append('select_trainner_emp_add', select_trainner_emp_add);
        Data.append('date_trainner_add', date_trainner_add);
        Data.append('select_trainner_class_add', select_trainner_class_add);
        Data.append('input_trainner_time_start', input_trainner_time_start);
        Data.append('input_trainner_time_end', input_trainner_time_end);
        Data.append('radioValue', radioValue);
        $.ajax({
            url: 'Save_trainner',
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
                $("#select_trainner_emp_add").val('');
                $("#date_trainner_add").val('');
                $("#select_trainner_class_add").val('');
                $("#input_trainner_time_start").val('');
                $("#input_trainner_time_end").val('');
                $("#Check_1").attr('checked', true);
                $("#Add_trainner").modal('hide');
                Table_trainner.draw();
            }
        });
    }
}

var Save_trainner_edit = function Save_trainner_edit() {
    var date_trainner_edit = $("#date_trainner_edit").val();
    var modal_trainner_emp_edit = $("#modal_trainner_emp_edit").val();
    var modal_trainner_class_edit = $("#modal_trainner_class_edit").val();
    var Radios_edit = $("input[name='exampleRadios_edit']:checked").val();
    var input_trainner_time_start_edit = $("#input_trainner_time_start_edit").val();
    var input_trainner_time_end_edit = $("#input_trainner_time_end_edit").val();
    var trainnerid_edit_model = $("#trainnerid_edit_model").val();
    //เอาข้อมูลเข้า Array
    var Data = new FormData();
    Data.append('date_trainner_edit', date_trainner_edit);
    Data.append('modal_trainner_emp_edit', modal_trainner_emp_edit);
    Data.append('modal_trainner_class_edit', modal_trainner_class_edit);
    Data.append('Radios_edit', Radios_edit);
    Data.append('input_trainner_time_start_edit', input_trainner_time_start_edit);
    Data.append('input_trainner_time_end_edit', input_trainner_time_end_edit);
    Data.append('trainnerid_edit_model', trainnerid_edit_model);
    $.ajax({
        url: 'Save_trainner_edit',
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
            $("#date_trainner_edit").val('');
            $("#Edit_trainner").modal('hide');
            Table_trainner.draw();
        }
    });
}

var Save_Trainner_emp = function Save_Trainner_emp() {
    var Fname = $("#firstname_trainner").val();
    var Lname = $("#lastname_trainner").val();
    var Class = $("#classname_trainner").val();
    if (Fname == '') {
        alert("กรอก ชื่อ - ผุ้สอน");
        $("#firstname_trainner").focus();
    } else if (Lname == '') {
        alert("กรอก นามสกุล - ผู้สอน");
        $("#lastname_trainner").focus();
    } else if (Class == '0') {
        alert('เลือก Class ที่ เทรนเนอร์ สอน');
        $("#classname_trainner").focus();
    } else if ($("#classname_trainner").val() == '0') {
        alert('กรุณาเลือกประเภทการสอน');
    } else {
        //Add Data To Form
        var Data = new FormData();
        Data.append('firstname', Fname);
        Data.append('lastname', Lname);
        Data.append('classname', Class);
        $.ajax({
            url: 'Save_Trainner_emp',
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
                $("#Add_trainner_emp").modal('hide');
                Table_trainner_emp.draw();
            }
        });
    }
}

var Save_edit_Trainner_emp = function Save_edit_Trainner_emp() {
    if ($("#firstname_trainner_edit").val() == '') {
        alert('กรุณา กรอก Code');
        $("#firstname_trainner_edit").focus();
    } else if ($("#lastname_trainner_edit").val() == '') {
        alert('กรุณา กรอก Name');
        $("#lastname_trainner_edit").focus();
    } else if ($("#classname_trainner_edit").val() == '') {
        alert('กรุณา กรอก Price');
        $("#classname_trainner_edit").focus();
    } else if ($("#classname_trainner_edit").val() == '0') {
        alert('กรุณาเลือกประเภทการสอน');
    } else {
        //Add Data To Form
        var Data = new FormData();
        Data.append('firstname', $("#firstname_trainner_edit").val());
        Data.append('lastname', $("#lastname_trainner_edit").val());
        Data.append('classname', $("#classname_trainner_edit").val());
        Data.append('id_emp', $("#hidden_trainner_emp_id").val());
        $.ajax({
            url: 'Save_edit_Trainner_emp',
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
                $("#Edit_Trainner_emp").modal('hide');
                Table_trainner_emp.draw();
            }
        });
    }
}

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
    } else {
        //Add Data To Form
        var Data = new FormData();
        Data.append('add_type_code', $("#add_type_code").val());
        Data.append('add_type_name', $("#add_type_name").val());
        Data.append('add_type_commitment', $("#add_type_commitment").val());
        Data.append('add_type_day', $("#add_type_day").val());
        Data.append('add_type_month', $("#add_type_month").val());
        Data.append('add_type_year', $("#add_type_year").val());
        Data.append('add_price', $("#add_price").val());
        Data.append('add_free_sum_package', $("#add_free_sum_package").val());
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
                    Table_type.draw();
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
        Data.append('edit_free_sum_package', $("#edit_free_sum_package").val());
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
                    Table_type.draw();
                }
            }
        });
    }
}

// Table Tab1
$.fn.dataTable.ext.errMode = 'throw';
var Table_type = $('#Table_type').DataTable({
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
            "targets": [0, 1]
        },
        {
            "className": 'text-center',
            "targets": [7]
        },
        {
            "className": 'text-right',
            "targets": [2, 3, 4, 5, 6]
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
    "search": {
        "regex": true
    },
});

var Table_trainner_emp = $('#Table_trainner_emp').DataTable({
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
        "url": 'Table_trainner_emp',
        "type": 'POST',
        "headers": {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    },
    "columns": [{
            "data": 'name_emp',
            "name": 'name_emp',
        },
        {
            "data": 'status_emp',
            "name": 'status_emp'
        },
        {
            "data": 'action',
            "name": 'action',
        },
    ],
    "columnDefs": [{
            "className": 'text-left',
            "targets": [0, 1]
        },
        {
            "className": 'text-center',
            "targets": [2]
        },
        {
            "className": 'text-right',
            "targets": []
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
    "search": {
        "regex": true
    },
});

var Table_trainner = $('#Table_trainner').DataTable({
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
        "url": 'Table_trainner',
        "type": 'POST',
        "headers": {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    },
    "columns": [{
            "data": 'name_emp',
            "name": 'name_emp',
        },
        {
            "data": 'item_name',
            "name": 'item_name'
        },
        {
            "data": 'every_day',
            "name": 'every_day'
        },
        {
            "data": 'train_date',
            "name": 'train_date'
        },
        {
            "data": 'train_time_sum',
            "name": 'train_time_sum'
        },
        {
            "data": 'action',
            "name": 'action'
        }
    ],
    "columnDefs": [{
            "className": 'text-left',
            "targets": [0, 1, 2]
        },
        {
            "className": 'text-center',
            "targets": [3, 4, 5]
        },
        {
            "className": 'text-right',
            "targets": []
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
    "search": {
        "regex": true
    },
    "order": [
        [3, "asc"]
    ]
});
