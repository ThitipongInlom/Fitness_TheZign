$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
    $('#Find_the_name').on('show.bs.modal', function (e) {
        $("#namesearching").attr('disabled', '');
        $("#namesearchingstatus").html('<span class="badge badge-secondary" style="margin-top: 10px;">เลือกประเภทที่จะค้นหา</span>');
    });
    $('#Find_the_name').on('hidden.bs.modal', function (e) {
        $("#namesearching").val('');
        $("#table_find_name").html('');
    });
    $('#Find_thezign_name').on('hidden.bs.modal', function (e) {
        $("#namesearchingthezign").val('');
        $("#table_find_name_thezign").html('');
    });
    Check_K_bank();
    // Ajax Get Data TO Fake Data
    setTimeout(function () {
        DisplayTable();
    }, 100);
    setTimeout(function () {
        TablePane();
    }, 200);
    setTimeout(function () {
        DisplayPackage();
    }, 300);
    setTimeout(function () {
        PackageItem();
    }, 400);
    setTimeout(function () {
        PackageOnuseDisplay();
    }, 500);
});

var searchinguse = function searchinguse() {
    $("#namesearching").attr('status', 'use');
    $("#namesearchingstatus").html('<span class="badge badge-primary" style="margin-top: 10px;">เลือกค้นหาเฉพาะ ใช้งาน</span>');
    $("#namesearching").removeAttr('disabled');
    $("#namesearching").focus();
}

var searchingall = function searchingall() {
    $("#namesearching").attr('status', 'all');
    $("#namesearchingstatus").html('<span class="badge badge-primary" style="margin-top: 10px;">เลือกค้นหา ทั้งหมด</span>');
    $("#namesearching").removeAttr('disabled');
    $("#namesearching").focus();
}

var searchingname = function searchingname(e) {
    var name = $("#namesearching").val();
    var status = $("#namesearching").attr("status");
    // Create From Data
    var Data = new FormData();
    // Data Put Array
    Data.append('name', name);
    Data.append('status', status);
    $.ajax({
        url: 'Namesearching',
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
            $("#table_find_name").html(res.Table);
        }
    });
}

var posttocheckin = function posttocheckin(e) {
    var csrf = $('meta[name="csrf-token"]').attr('content');
    var code = $(e).attr('code');
    $('#Find_the_name').modal('hide');
    setTimeout(function () {
        $.redirect("CheckIn", {
            _token: csrf,
            inputcode: code
        }, "POST");
    }, 500);
}

var CheckInOnline = function CheckInOnline(e) {
    var Code = $("#codehidden").val();
    $.ajax({
        url: 'CheckInOnline',
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            Code: Code
        },
        success: function (res) {
            $.redirect("Dashboard", {}, "GET");
        }
    });
}

var Item_To_Disktop = function Item_To_Disktop(e) {
    // Check Code
    var Code = $("#codehidden").val();
    // Check Type
    var Item_code = $(e).attr('item_code');
    var Item_type = $(e).attr('item_type');
    var Item_name = $(e).attr('item_name');
    var Item_price = $(e).attr('item_price');
    var Item_codetype = $(e).attr('item_codetype');
    var Item_setnumber = $(e).attr('item_setnumber');
    // Create From Data
    var Data = new FormData();
    // Data Put Array
    Data.append('Code', Code);
    Data.append('Item_code', Item_code);
    Data.append('Item_type', Item_type);
    Data.append('Item_name', Item_name);
    Data.append('Item_price', Item_price);
    Data.append('Item_codetype', Item_codetype);
    Data.append('Item_setnumber', Item_setnumber);
    // Type L   == General
    if (Item_type == 'L') {
        $.ajax({
            url: 'Insert_type_L',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'text',
            cache: false,
            contentType: false,
            processData: false,
            data: Data,
        });
    }
    // Type C  == Course
    if (Item_type == 'C') {
        $.ajax({
            url: 'Insert_type_C',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            data: Data,
           success: function (res) {
               trianner_class_select_modal('<div fake_table_id="' + res.fake_id + '"></div>');
           }
        });
    }
    // Type P  == Package
    if (Item_type == 'P') {
        $.ajax({
            url: 'Insert_type_P',
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
                trianner_emp_select_modal('<div fake_table_id="' + res.fake_id + '"></div>');
            }
        });

    }
    // Display Hide
    $("#DisplayItemList").addClass("flipOutX");
    $("#DisplayItemList").html('');
    // Ajax Get Data TO Fake Data
    setTimeout(function () {
        DisplayTable();
        DisplayPackage();
        PackageItem();
    }, 200);
}

var DisplayTable = function DisplayTable() {
    // Check Code
    var Code = $("#codehidden").val();
    // Create From Data
    var Data = new FormData();
    // Data Put Array
    Data.append('Code', Code);
    // Ajax Get Data TO Fake Data
    $.ajax({
            url: 'TableDisplay',
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
                $("#DisplayItemList").html(res.Table);
                $('[data-toggle="tooltip"]').tooltip();
            }
        })
        .fail(function () {
            DisplayTable();
        });
}

var TablePane = function TablePane() {
    // Check Code
    var Code = $("#codehidden").val();
    // Create From Data
    var Data = new FormData();
    // Data Put Array
    Data.append('Code', Code);
    // Ajax Get Data TO Fake Data
    $.ajax({
            url: 'TablePane',
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
                $("#PaneItem").html(res.Navtab);
            }
        })
        .fail(function () {
            TablePane();
        });
}

var Edit_Number = function Edit_Number(e) {
    // Modal Show
    $('#Edit_Number').modal('show');
    $("body").css("padding-right", "0");
    // Data SetToSend
    var Fake_table_id = $(e).attr('fake_table_id');
    // Create From Data
    var Data = new FormData();
    // Data Put Array
    Data.append('Fake_table_id', Fake_table_id);
    // Ajax To Send
    $.ajax({
        url: 'Edit_Number',
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
            $("#edit_number_display").html(res.From);
        }
    });
}

var Discount = function Discount(e) {
    // Modal Show
    $('#Discount_modal').modal('show');
    $("body").css("padding-right", "0");
    // Data SetToSend
    var Fake_table_id = $(e).attr('fake_table_id');
    // Create From Data
    var Data = new FormData();
    // Data Put Array
    Data.append('Fake_table_id', Fake_table_id);
    // Ajax To Send
    $.ajax({
        url: 'Discount',
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
            $("#Discount_Display").html(res.From);
        }
    });
}

var Edit_Number_Key = function Edit_Number_Key(e) {
    // Modal Show
    $('#Edit_Number_Key').modal('show');
    $("body").css("padding-right", "0");
    // Data SetToSend
    var Fake_table_id = $(e).attr('fake_table_id');
    // Create From Data
    var Data = new FormData();
    // Data Put Array
    Data.append('Fake_table_id', Fake_table_id);
    // Ajax To Send
    $.ajax({
        url: 'Edit_Number_Key',
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
            $("#edit_number_display_key").html(res.From);
        }
    });
}

var Edit_Other = function Edit_Other(e) {
    // Modal Show
    $('#Edit_Other').modal('show');
    $("body").css("padding-right", "0");
    // Data SetToSend
    var Fake_table_id = $(e).attr('fake_table_id');
    // Create From Data
    var Data = new FormData();
    // Data Put Array
    Data.append('Fake_table_id', Fake_table_id);
    // Ajax To Send
    $.ajax({
        url: 'Edit_Other',
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
            $("#Edit_Other_display_key").html(res.From);
        }
    });
}

var Life_ring = function Life_ring(e) {
    // Modal Show
    $('#Life_ring').modal('show');
    $("body").css("padding-right", "0");
    // Data SetToSend
    var Fake_table_id = $(e).attr('fake_table_id');
    // Create From Data
    var Data = new FormData();
    // Data Put Array
    Data.append('Fake_table_id', Fake_table_id);
    // Ajax To Send
    $.ajax({
        url: 'Life_ring',
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: 'text',
        cache: false,
        contentType: false,
        processData: false,
        data: Data,
        success: function (res) {
            console.log(res);
        }
    });
}

var Delete_item = function Delete_item(e) {
    // Data SetToSend
    var Fake_table_id = $(e).attr('fake_table_id');
    // Create From Data
    var Data = new FormData();
    // Data Put Array
    Data.append('Fake_table_id', Fake_table_id);
    // Ajax To Send
    $.ajax({
        url: 'Delete_item',
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
            setTimeout(function () {
                DisplayTable();
            }, 10);
        }
    });
}

var Delete_item_time = function Delete_item_time(e) {
    // Data SetToSend
    var Fake_table_id = $(e).attr('fake_table_id');
    // Create From Data
    var Data = new FormData();
    // Data Put Array
    Data.append('Fake_table_id', Fake_table_id);
    // Ajax To Send
    $.ajax({
        url: 'Delete_item_time',
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
            setTimeout(function () {
                DisplayTable();
                DisplayPackage();
                PackageItem();
            }, 10);
        }
    });
}

var Foronchangenum = function Foronchangenum(e) {
    // Data SetToSend
    var NewNum = $('#newnumitem').val();
    var Fake_table_id = $(e).attr('Fake_table_id');
    // Create From Data
    var Data = new FormData();
    // Data Put Array
    Data.append('Fake_table_id', Fake_table_id);
    Data.append('NewNum', NewNum);
    // Ajax To Send
    $.ajax({
        url: 'Foronchangenum',
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
            setTimeout(function () {
                // Modal Hide
                $('#Edit_Number').modal('hide');
                DisplayTable();
            }, 10);
        }
    });
}

var Foronchangenumkey = function Foronchangenumkey(e) {
    // Data SetToSend
    var NewNum = $('#newnumitem').val();
    var Fake_table_id = $(e).attr('Fake_table_id');
    // Create From Data
    var Data = new FormData();
    // Data Put Array
    Data.append('Fake_table_id', Fake_table_id);
    Data.append('NewNum', NewNum);
    // Ajax To Send
    $.ajax({
        url: 'Foronchangenum',
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
            setTimeout(function () {
                // Modal Hide
                $('#Edit_Number_Key').modal('hide');
                DisplayTable();
            }, 10);
        }
    });
}

var ForonEdit_Other = function ForonEdit_Other(e) {
    // Data SetToSend
    var NewNum = $('#newnumitem').val();
    var Fake_table_id = $(e).attr('Fake_table_id');
    // Create From Data
    var Data = new FormData();
    // Data Put Array
    Data.append('Fake_table_id', Fake_table_id);
    Data.append('NewNum', NewNum);
    // Ajax To Send
    $.ajax({
        url: 'Foronchangenum',
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
            setTimeout(function () {
                // Modal Hide
                $('#Edit_Other').modal('hide');
                DisplayTable();
            }, 10);
        }
    });
}

var Discount_Save = function Discount_Save(e) {
    // Data SetToSend
    var NewNum = $('#newdiscount').val();
    var Fake_table_id = $(e).attr('Fake_table_id');
    // Create From Data
    var Data = new FormData();
    // Data Put Array
    Data.append('Fake_table_id', Fake_table_id);
    Data.append('NewNum', NewNum);
    // Ajax To Send
    $.ajax({
        url: 'Discount_Save',
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
            setTimeout(function () {
                // Modal Hide
                $('#Discount_modal').modal('hide');
                DisplayTable();
            }, 10);
        }
    });
}

var History = function History(e) {
    // Create From Data
    var Data = new FormData();
    // Data Put Array
    Data.append('Code', $("#codehidden").val());
    Data.append('Limit', $(e).attr('set_limit'));
    // Modal Show
    $('#History').modal('show');
    $("body").css("padding-right", "0");
    // Ajax Get Data To Table
    $.ajax({
            url: 'History',
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
                $("#History_display").html(res.Table);
            }
        })
        .fail(function () {
            History();
        });
}

var Find_the_name_Modal = function Find_the_name_Modal() {
    // Modal Show
    $('#Find_the_name').modal('show');
    $("body").css("padding-right", "0");
}

var Find_thezign_name_Modal = function Find_thezign_name_Modal() {
    // Modal Show
    $('#Find_thezign_name').modal('show');
    $("body").css("padding-right", "0");
}

var Airlink_modal_data = function Airlink_modal_data(e) {
    // Get Code
    var Text_Code = $(e).val();
    // Create From Data
    var Data = new FormData();
    // Data Put Array
    Data.append('Text_Code', Text_Code);
    // Ajax Send Data
    $.ajax({
            url: 'Airlink_modal_data',
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
                $("#table_find_name_thezign").html(res.Table);
            }
        })
        .fail(function () {
            Airlink_modal_data();
        });
}

var Send_To_Register = function Send_To_Register(e) {
    // Create From Data
    var Data = new FormData();
    // Data Put Array
    Data.append('account', $(e).attr('account'));
    Data.append('name', $(e).attr('name'));
    Data.append('start', $(e).attr('start'));
    Data.append('end', $(e).attr('end'));
    Data.append('room', $(e).attr('room'));
    Data.append('phone', $(e).attr('phone'));
    Data.append('username', $(e).attr('username'));
    // Ajax Send Data
    $.ajax({
            url: 'SendToRegister',
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
                var csrf = $('meta[name="csrf-token"]').attr('content');
                var res = jQuery.parseJSON(callback);
                if (res.Code == 'Error') {
                    console.log('Double Gen Data');
                } else {
                    var Redirect_Code = res.Code;
                    $.redirect("CheckIn", {
                        _token: csrf,
                        inputcode: Redirect_Code
                    }, "POST");
                }
            }
        })
        .fail(function () {
            Send_To_Register();
        });
}

var DisplayPackage = function DisplayPackage() {
    // Get Code
    var Code = $("#codehidden").val();
    // Create From Data
    var Data = new FormData();
    // Data Put Array
    Data.append('Code', Code);
    // Ajax Send Data
    $.ajax({
            url: 'DisplayPackage',
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
                $("#DisplayPackage").html(res.Table);
            }
        })
        .fail(function () {
            DisplayPackage();
        });
}

var PackageItem = function PackageItem() {
    // Get Code
    var Code = $("#codehidden").val();
    // Create From Data
    var Data = new FormData();
    // Data Put Array
    Data.append('Code', Code);
    // Ajax Send Data
    $.ajax({
            url: 'PackageItem',
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
                $("#PackageItem").html(res.Data);
            }
        })
        .fail(function () {
            PackageItem();
        });
}

var OnUsePackage = function OnUsePackage(e) {
    // Get Code
    var main_package_id = $(e).attr('main_package_id');
    var package_detail_id = $(e).attr('package_detail_id');
    var Code = $(e).attr('code');
    var total = $(e).attr('total');
    var havesum = $(e).attr('havesum');
    var trainner_emp = $(e).attr('trainner_emp');
    // Create From Data
    var Data = new FormData();
    // Data Put Array
    Data.append('Code', Code);
    Data.append('main_package_id', main_package_id);
    Data.append('package_detail_id', package_detail_id);
    Data.append('total', total);
    Data.append('havesum', havesum);
    Data.append('trainner_emp_id', trainner_emp);
    // Ajax Send Data
    $.ajax({
            url: 'OnUsePackage',
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
                PackageItem();
                DisplayPackage();
                PackageOnuseDisplay();
            }
        })
        .fail(function () {
            OnUsePackage();
        });
}

var PackageOnuseDisplay = function PackageOnuseDisplay() {
    // Get Code
    var Code = $("#codehidden").val();
    // Create From Data
    var Data = new FormData();
    // Data Put Array
    Data.append('Code', Code);
    // Ajax Send Data
    $.ajax({
            url: 'PackageOnuseDisplay',
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
                $("#PackageOnuseDisplay").html(res.Table);
            }
        })
        .fail(function () {
            PackageOnuseDisplay();
        });
}

var History_Package_Useing = function History_Package_Useing(e) {
    // Get Code
    var Code = $("#codehidden").val();
    var Package_id = $(e).attr('package_id');
    // Create From Data
    var Data = new FormData();
    // Data Put Array
    Data.append('Code', Code);
    Data.append('Package_id', Package_id);
    // Show Modal Modal_History_Package_Useing
    $("#Modal_History_Package_Useing").modal('show');
    $("body").css("padding-right", "0");
    // Ajax Send Data
    $.ajax({
            url: 'Modal_History_Package_Useing_Display',
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
                $("#Modal_History_Package_Useing_Display").html(res.Table);
            }
        })
        .fail(function () {
            History_Package_Useing();
        });
}

var DeleteOnusePackage = function DeleteOnusePackage(e) {
    // Get Code
    var Code = $(e).attr('code');
    var Package_onuse_id = $(e).attr('package_onuse_id');
    var Package_log_id = $(e).attr('package_log_id');
    var Main_package_id = $(e).attr('main_package_id');
    var Onusesum = $(e).attr('onusesum');
    // Create From Data
    var Data = new FormData();
    // Data Put Array
    Data.append('Code', Code);
    Data.append('Package_onuse_id', Package_onuse_id);
    Data.append('Package_log_id', Package_log_id);
    Data.append('Main_package_id', Main_package_id);
    Data.append('Onusesum', Onusesum);
    // Ajax Send Data
    $.ajax({
            url: 'DeleteOnusePackage',
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
                PackageItem();
                DisplayPackage();
                PackageOnuseDisplay();
            }
        })
        .fail(function () {
            DeleteOnusePackage();
        });
}

var Dologout = function Dologout(e) {
    var Main_id = $("#Main_idhidden").val();
    var Code = $("#codehidden").val();
    var Price = $("#pricehidden").val();
    var Priceformat = $("#pricehiddenformat").val();
    // Create From Data
    var Data = new FormData();
    // Data Put Array
    Data.append('Main_id', Main_id);
    Data.append('Code', Code);
    // Check Price Not Null
    if (Price > 0) {
        // Modal Show
        $('#Alertmodalcheckprice').modal('show');
        $("body").css("padding-right", "0");
        $("#displayalertprice").html('<h5><b>จำนวนเงินทั้งหมด ' + Priceformat + ' บาท</b></h5><hr>');
        $("#btnLogoutQuery").html('<button class="btn btn-success" code="' + Code + '" main_id="' + Main_id + '" onclick="LogoutQuery(this)">ยืนยัน</button>');
    } else {
        // Send Data Ajax To Query
        $.ajax({
                url: 'Dologout',
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
                    $.redirect("Dashboard", {}, "GET");
                }
            })
            .fail(function () {
                Dologout();
            });
    }
}

var LogoutQuery = function LogoutQuery(e) {
    var Main_id = $("#Main_idhidden").val();
    var Code = $("#codehidden").val();
    // Create From Data
    var Data = new FormData();
    // Data Put Array
    Data.append('Main_id', Main_id);
    Data.append('Code', Code);
    // Send Data Ajax To Query
    $.ajax({
            url: 'Dologout',
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
                $.redirect("Dashboard", {}, "GET");
            }
        })
        .fail(function () {
            LogoutQuery();
        });
}

var VoidItem = function VoidItem(e) {
    var Fake_id = $(e).attr('fake_table_id');
    var commentvoiditem = $("#commentvoiditem").val();
    // Create From Data
    var Data = new FormData();
    // Data Put Array
    Data.append('Fake_id', Fake_id);
    Data.append('commentvoiditem', commentvoiditem);
    // Send Data Ajax To Query
    $.ajax({
            url: 'VoidItem',
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
                $('#VoidItem_modal').modal('hide');
                DisplayTable();
                DisplayPackage();
                PackageItem();
            }
        })
        .fail(function () {
            VoidItem();
        });
}

var VoidItem_modal = function VoidItem_modal(e) {
    var Fake_id = $(e).attr('fake_table_id');
    // Create From Data
    var Data = new FormData();
    // Modal Show
    $('#VoidItem_modal').modal('show');
    $("body").css("padding-right", "0");
    // Data Put Array
    Data.append('Fake_id', Fake_id);
    // Send Data Ajax To Query
    $.ajax({
            url: 'VoidItem_modal',
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
                $("#Voiditem_Display").html(res.Table);
            }
        })
        .fail(function () {
            VoidItem_modal();
        });
}

var ChargeItem = function ChargeItem(e) {
    var Fake_id = $(e).attr('fake_table_id');
    var inputchargeitem = $("#inputchargeitem").val();
    var commentchargeitem = $("#commentchargeitem").val();
    // Create From Data
    var Data = new FormData();
    // Data Put Array
    Data.append('Fake_id', Fake_id);
    Data.append('inputchargeitem', inputchargeitem);
    Data.append('commentchargeitem', commentchargeitem);
    // Send Data Ajax To Query
    $.ajax({
        url: 'ChargeItem',
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: 'text',
        cache: false,
        contentType: false,
        processData: false,
        data: Data,
        success: function (callblack) {
            $('#Charge_modal').modal('hide');
            DisplayTable();
            DisplayPackage();
            PackageItem();
        }
    });
}

var Charge_modal = function Charge_modal(e) {
    var Fake_id = $(e).attr('fake_table_id');
    // Create From Data
    var Data = new FormData();
    // Modal Show
    $('#Charge_modal').modal('show');
    $("body").css("padding-right", "0");
    // Data Put Array
    Data.append('Fake_id', Fake_id);
    // Send Data Ajax To Query
    $.ajax({
        url: 'Charge_modal',
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
            $("#Charge_Display").html(res.Table);
        }
    });
}

var Check_K_bank = function Check_K_bank() {
    $.ajax({
        url: 'Check_K_bank',
        type: 'GET',
        success: function (res) {
            $("#count_kbank").html('<button style="margin-left:10px;" class="btn btn-sm ' + res.Class + '" id="count_kbank">ลูกค้า K-bank ' + res.Count + ' คน</button>');
        }
    });
}

var trianner_emp_select_modal = function trianner_emp_select_modal(e) {
    // Modal Show
    $('#trianner_emp_select_modal').modal('show');
    $("body").css("padding-right", "0");
    var Data = new FormData();
    Data.append('Fake_id', $(e).attr('fake_table_id'));
    $.ajax({
        url: 'Display_select_trainner_emp',
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
            $("#Display_select_trainner_emp").html(res.select);
        }
    });
}

var trianner_emp_select_modal_edit = function trianner_emp_select_modal_edit(e) {
    // Modal Show
    $('#trianner_emp_select_modal_edit').modal('show');
    $("body").css("padding-right", "0");
    var Data = new FormData();
    Data.append('Fake_id', $(e).attr('on_use_id'));
    $.ajax({
        url: 'Display_select_trainner_emp_edit',
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
            $("#Display_select_trainner_emp_edit").html(res.select);
        }
    });
}

var save_trainner_emp_select_modal = function save_trainner_emp_select_modal(e) {
    var Data = new FormData();
    Data.append('Fake_id', $(e).attr('fake_table_id'));
    Data.append('Trainner_emp_id', $("#select_emp_to_member").val());
    $.ajax({
        url: 'Save_select_trainner_emp_to_member',
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
            $('#trianner_emp_select_modal').modal('hide');
            DisplayTable();
            PackageItem();
            DisplayPackage();
        }
    });
}

var save_trainner_emp_select_modal_edit = function save_trainner_emp_select_modal_edit(e) {
    var Data = new FormData();
    Data.append('Fake_id', $(e).attr('fake_table_id'));
    Data.append('Trainner_emp_id', $("#select_emp_to_member_edit").val());
    $.ajax({
        url: 'Save_select_trainner_emp_to_member_edit',
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
            $('#trianner_emp_select_modal_edit').modal('hide');
            PackageItem();
            PackageOnuseDisplay();
        }
    });
}

var trianner_class_select_modal = function trianner_class_select_modal(e) {
    // Modal Show
    $('#trianner_class_select_modal').modal('show');
    $("body").css("padding-right", "0");
    var Data = new FormData();
    Data.append('Fake_id', $(e).attr('fake_table_id'));
    $.ajax({
        url: 'Display_select_trainner_class',
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
            $("#Display_select_trainner_class").html(res.select);
        }
    });
}

var save_trainner_class_select_modal = function save_trainner_class_select_modal(e) {
    var Data = new FormData();
    Data.append('Fake_id', $(e).attr('fake_table_id'));
    Data.append('Trainner_emp_id', $("#select_class_to_member").val());
    $.ajax({
        url: 'Save_select_trainner_class_to_member',
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
            $('#trianner_class_select_modal').modal('hide');
            DisplayTable();
            PackageItem();
            DisplayPackage();
        }
    });
}
