$(document).ready(function () {
    // Toastr Options
    Toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "3000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    $("#col_adduser_model_sub").hide();
    Backtotop();
    // Set Remove 
    setInterval(() => {
        $.ajax({
            url: "http://172.16.1.239:3000",
            type: "GET",
            crossDomain: true,
            success: function (data) {
                if (data.status == 'Success') {
                    $("#read_card").removeClass('btn-danger');
                    $("#read_card").addClass('btn-primary');
                    $("#read_card").removeAttr('disabled');
                    $("#read_card_text").html('Import Data');
                } else if (data.status == 'Remove') {
                    $("#col_adduser_model_sub").hide();
                    $("#AddUsermodelsize").removeClass('modal-lg');
                    $("#col_adduser_model_sub").removeClass('col-md-4');
                    $("#col_adduser_model_main").addClass('col-md-12');
                    $("#col_adduser_model_main").removeClass('col-md-8');

                    $("#read_card").removeClass('btn-primary');
                    $("#read_card").addClass('btn-danger');
                    $("#read_card").attr('disabled', 'disabled');
                    $("#read_card_text").html('Insert ID Card');
                }
            }
        });
        }, 3000);
});

var Backtotop = function Backtotop() {
    $('body').append('<div id="toTop" class="btn btn-outline-primary"><i class="fas fa-arrow-up"></i> ขึ้นบน</div>');
    $(window).scroll(function () {
        if ($(this).scrollTop() != 0) {
            $('#toTop').fadeIn();
        } else {
            $('#toTop').fadeOut();
        }
    });
    $('#toTop').click(function () {
        $("html, body").animate({
            scrollTop: 0
        }, 800);
        return false;
    });
}

$.fn.dataTable.ext.errMode = 'throw';
var csrf = $('meta[name="csrf-token"]').attr('content');
var TableDisplay = $('#TableDisplay').DataTable({
    "dom": "<'row'<'col-sm-1'l><'col-sm-7'><'col-sm-4'>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-1'i><'col-sm-7'><'col-sm-4'p>>",
    "processing": true,
    "serverSide": true,
    "bPaginate": true,
    "responsive": true,
    "order": [
        [4, 'desc'],
        [9, 'asc']
    ],
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
    "columnDefs": [{
            "className": 'text-left',
            "targets": [2, 8]
        },
        {
            "className": 'text-center',
            "targets": [0, 1, 3, 4, 5, 6, 7, 9, 10, 11]
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

$('#searchTableDisplay').on('click', function (e) {
    TableDisplay.draw();
    e.preventDefault();
});

var hide_card = function hide_card() {
    $("#col_adduser_model_sub").hide();
    $("#AddUsermodelsize").removeClass('modal-lg');
    $("#col_adduser_model_sub").removeClass('col-md-4');
    $("#col_adduser_model_main").addClass('col-md-12');
    $("#col_adduser_model_main").removeClass('col-md-8');
}

var AddUsermodel = function AddUsermodel() {
    // Show Modal
    $("#AddUsermodel").modal('show');
    $("body").css("padding-right", "0");
    $('[data-toggle="datepicker"]').datepicker({
        language: 'en',
        autoClose: true,
    });
}

var ViewData = function ViewData(e) {
    // Show Modal
    $("#ViewDataUser").modal('show');
    $("body").css("padding-right", "0");
    var id = $(e).attr('id');
    // Create From Data
    var Data = new FormData();
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
        success: function (callback) {
            var res = jQuery.parseJSON(callback);
            $("#ViewDataUserDisplay").html(res.Table);
            $('[data-toggle="datepicker"]').datepicker({
                language: 'en',
                container: '#date_modal_start',
                autoClose: true,
            });
            Modal_table_document(res.Code);
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
                        "order": [
                            [0, "desc"]
                        ],
                        "lengthMenu": [
                            [5, ],
                            [5, ]
                        ],
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
                            {
                                "data": 'type',
                                "name": 'type'
                            },
                        ],
                        "columnDefs": [{
                                "className": 'text-left',
                                "targets": [0, ]
                            },
                            {
                                "className": 'text-center',
                                "targets": [1, 2, 3]
                            },
                            {
                                "className": 'text-right',
                                "targets": [4, 5, 6, 7]
                            },
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
        success: function (callback) {
            var res = jQuery.parseJSON(callback);
            var User_Id = '<div id="' + res.text + '"></div>';
            $("#ViewDataUser").modal('hide');
            setTimeout(function () {
                ViewData(User_Id);
            }, 500);
        }
    });
}

var Calculate_Day = function Calculate_Day(e) {
    var Daystart = $("#Start_Add").val();
    var SelectVal = $(e).val();
    // Create From Data
    var Data = new FormData();
    Data.append('Daystart', Daystart);
    Data.append('SelectVal', SelectVal);
    $.ajax({
        url: 'Calculate_Day',
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
            $("#Code_Add").val(res.New_Code);
            $("#Start_Add").val(res.DateStart);
            $("#End_Add").val(res.DateEnd);
            $("#Price_full_Add").val(res.PriceType);
            $("#Price_total_Add").val(res.PriceType);
            $("#Discount_Add").val('0');
        }
    });
}

var onchange_discount_add = function onchange_discount_add(e) {
    var Price_full_Add = $("#Price_full_Add").val();
    var Discount = $(e).val();
    var Price_total_Add = Price_full_Add - Discount;
    $("#Price_total_Add").val(Price_total_Add);
}

$('#AddUsermodel').on('hidden.bs.modal', function (e) {
    $("#col_adduser_model_sub").hide();
    $("#AddUsermodelsize").removeClass('modal-lg');
    $("#col_adduser_model_sub").removeClass('col-md-4');
    $("#col_adduser_model_main").addClass('col-md-12');
    $("#col_adduser_model_main").removeClass('col-md-8');
    $("#Code_Add").val('');
    $("#Name_Add").val('');
    $("#Start_Add").val('');
    $("#End_Add").val('');
    $("#Birthday_Add").val('');
    $("#Phone_Add").val('');
    $("#Address_Add").val('');
    $("#Type_Add").val('0');
    $("#Price_full_Add").val('');
    $("#Discount_Add").val('');
    $("#Remark_Add").val('');
    $("#Price_total_Add").val('');
    $("#id_card_add").val('');
    $("#card_start_add").val('');
    $("#card_end_add").val('');
    $("#card_img_add").val('');
    $("#gender").val('');
});

var GenerateWiFi = function GenerateWiFi() {
    // Create From Data
    var Data = new FormData();
    Data.append('Code_Add', $("#Code_Add").val());
    Data.append('Name_Add', $("#Name_Add").val());
    Data.append('Start_Add', $("#Start_Add").val());
    Data.append('End_Add', $("#End_Add").val());
    Data.append('Birthday_Add', $("#Birthday_Add").val());
    Data.append('Phone_Add', $("#Phone_Add").val());
    Data.append('Address_Add', $("#Address_Add").val());
    Data.append('Type_Add', $("#Type_Add").val());
    Data.append('Price_full_Add', $("#Price_full_Add").val());
    Data.append('Discount_Add', $("#Discount_Add").val());
    Data.append('Remark_Add', $("#Remark_Add").val());
    Data.append('Price_total_Add', $("#Price_total_Add").val());
    Data.append('id_card_add', $("#id_card_add").val());
    Data.append('card_start_add', $("#card_start_add").val());
    Data.append('card_end_add', $("#card_end_add").val());
    Data.append('card_img_add', $("#card_img_add").val());
    Data.append('gender', $("#gender").val());
    if ($("#Code_Add").val() != '' && $("#Name_Add").val() != '') {
        $.ajax({
            url: 'GenerateWiFi',
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
                $("#AddUsermodel").modal('hide');
                TableDisplay.draw();
                //e.preventDefault();
                console.log(callback);
                $("#Code_Add").val('');
                $("#Name_Add").val('');
                $("#Start_Add").val('');
                $("#End_Add").val('');
                $("#Birthday_Add").val('');
                $("#Phone_Add").val('');
                $("#Address_Add").val('');
                $("#Type_Add").val('0');
                $("#Price_full_Add").val('');
                $("#Discount_Add").val('');
                $("#Remark_Add").val('');
                $("#Price_total_Add").val('');
                $("#id_card_add").val('');
                $("#card_start_add").val('');
                $("#card_end_add").val('');
                $("#card_img_add").val('');
                $("#gender").val('');
            }
        });
    } else {
        console.log('Alert');
    }
}

var StopMB = function StopMB(e) {
    var Mumber = $(e).val();
    var Start = $(e).attr('start');
    // Create From Data
    var Data = new FormData();
    Data.append('Mumber', Mumber);
    Data.append('Start', Start);
    $.ajax({
        url: 'StopMB',
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
            $("#remember_reconnent_end").val(res.End_StopMB);
        }
    });
}

var Calculate_renewal = function Calculate_renewal(e) {
    // GET DATA
    var Date_start = $("#remember_reconnent_start").val();
    var Data_Type = $(e).val();
    if (Data_Type == 'Stop') {
        // Remove Disabled
        $("#remember_reconnent_stopmb").removeAttr("disabled");
        $("#remember_reconnent_stopmb").focus();
        $("#remember_reconnent_discount").val("0");
    } else {
        // Set Disabled
        $("#remember_reconnent_stopmb").attr("disabled", "disabled");
        $("#remember_reconnent_stopmb").val("");
        $("#remember_reconnent_discount").val("0");
    }
    // Create From Data
    var Data = new FormData();
    Data.append('start', $("#remember_reconnent_start").val());
    Data.append('Code', $("#model_code_viewdata").val());
    Data.append('Type', $("#remember_reconnent_type").val());
    // Ajax
    $.ajax({
        url: 'Calculate_renewal',
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
            $("#remember_reconnent_start").val(res.start);
            $("#remember_reconnent_end").val(res.expire);
            $("#remember_reconnent_price_full").val(res.price);
            $("#remember_reconnent_price_total").val(res.price);
        }
    });
}

var editmember = function editmember() {
    // Create From Data
    var Data = new FormData();
    Data.append('code', $("#model_code_viewdata").val());
    Data.append('birthday', $("#edit_birthday_input").val());
    Data.append('phone', $("#edit_phone_input").val());
    Data.append('address', $("#edit_address_input").val());
    $.ajax({
        url: 'Edit_member',
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
            var User_Id = '<div id="' + res.code + '"></div>';
            $("#ViewDataUser").modal('hide');
            setTimeout(function () {
                ViewData(User_Id);
            }, 500);
            TableDisplay.draw();
        }
    });
}

var onchange_discount = function onchange_discount(e) {
    var discount_total = $(e).val();
    var price_full = $("#remember_reconnent_price_full").val();
    var Result_discount = price_full - discount_total;
    $("#remember_reconnent_price_total").val(Result_discount);
}

var remember_reconnent_airlink = function remember_reconnent_airlink() {
    // Create From Data
    var Data = new FormData();
    Data.append('code', $("#model_code_viewdata").val());
    Data.append('start_date', $("#remember_reconnent_start").val());
    Data.append('end_date', $("#remember_reconnent_end").val());
    Data.append('stopmb', $("#remember_reconnent_stopmb").val());
    Data.append('remark', $("#remember_reconnent_remark").val());
    Data.append('type', $("#remember_reconnent_type").val());
    Data.append('price_full', $("#remember_reconnent_price_full").val());
    Data.append('discount', $("#remember_reconnent_discount").val());
    Data.append('price_total', $("#remember_reconnent_price_total").val());
    // Ajax
    $.ajax({
        url: 'Remember_reconnent_airlink',
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
            $("#ViewDataUser").modal('hide');
            TableDisplay.draw();
        }
    });
}

var Getdatacard = function Getdatacard() {
    $.ajax({
        url: "http://172.16.1.239:3000",
        type: "GET",
        crossDomain: true,
        success: function (data) {
            if (data.status == 'Remove') {
                Toastr["info"]('กรุณาใส่ บัตรประชาชน');
            } else if (data.status == 'Inserted') {
                Toastr["info"]('กำลังอ่าน บัตรประชาชน กรุณารอซักครู่');
                setTimeout(function () {
                    Getdatacard();
                }, 3000);
            } else if (data.status == 'Reading') {
                Toastr["info"]('กำลังอ่าน บัตรประชาชน กรุณารอซักครู่');
                setTimeout(function () {
                    Getdatacard();
                }, 3000);
            } else if (data.status == 'Success') {
                $("#col_adduser_model_sub").show();
                $("#AddUsermodelsize").addClass('modal-lg');
                $("#col_adduser_model_sub").addClass('col-md-4');
                $("#col_adduser_model_main").removeClass('col-md-12');
                $("#col_adduser_model_main").addClass('col-md-8');

                $("#addmodel_card_img").attr('src', data.photo);
                $("#addmode_card_idnumber").html('เลขประจำตัว : ' + data.citizenId);
                $("#addmodel_card_name").html('ชื่อ-นามสกุล : '+ data.firstNameEN + ' ' + data.lastNameEN);
                $("#addmodel_card_address").html('ที่อยู่ : ' + data.address);

                var newdate = new Date(data.birthday);
                var date = newdate.getDate();
                var month = newdate.getMonth() + 1;
                var year = newdate.getFullYear();
                $("#Birthday_Add").val(date + '/' + month + '/' + year);
                $("#Name_Add").val(data.firstNameEN + ' ' + data.lastNameEN);
                $("#Address_Add").val(data.address);
                $("#id_card_add").val(data.citizenId);
                $("#card_start_add").val(data.issue);
                $("#card_end_add").val(data.expire);
                $("#card_img_add").val(data.photo);
                $("#gender").val(data.gender);
                Toastr["info"]('ใส่ข้อมูล เสร็จสิ้น');
            }
        },
        error: function () {
            Toastr["error"]('กรุณา เปิด รัน Service Card');
        }
    });
}

var Upload_member_image_document = function Upload_member_image_document() {
    var Img = $("#modal_document_member_image").prop('files')[0];
    var Code = $("#model_code_viewdata").val();
    var type_update = 'image';
    var Data = new FormData();
    Data.append('Img', Img);
    Data.append('Code', Code);
    Data.append('type_update', type_update);
    $.ajax({
        url: 'Upload_member_document',
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
            console.log(callback);
        }
    });
}

var Upload_member_file_document = function Upload_member_file_document() {
    var Img = $("#modal_document_member_file").prop('files')[0];
    var Code = $("#model_code_viewdata").val();
    var type_update = 'file';
    var Data = new FormData();
    Data.append('Img', Img);
    Data.append('Code', Code);
    Data.append('type_update', type_update);

    $.ajax({
        url: 'Upload_member_document',
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
            console.log(callback);
        }
    });
}

var Modal_table_document = function modal_table_document(Code) {
    var Data = new FormData();
    Data.append('Code', Code);

    $.ajax({
        url: 'Get_Table_document',
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: Data,
        success: function (callback) {
            $("#modal_table_document").append(callback.Table);
        }
    });
}
