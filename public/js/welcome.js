$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
    setTimeout(function() {
        OnlineTable();
    }, 10);
    setTimeout(function() {
        TableToday();
    }, 30);
});

var OnlineTable = function OnlineTable() {
    $.ajax({
            url: 'TableOnline',
            type: 'GET',
            success: function(callback) {
                var res = jQuery.parseJSON(callback);
                $("#TableOnline").html(res.Table);
            }
        })
        .fail(function() {
            OnlineTable();
        });
}

var TableToday = function TableToday() {
    $.ajax({
            url: 'TableToday',
            type: 'GET',
            success: function(callback) {
                $("body").css("padding-right", "0");
                var res = jQuery.parseJSON(callback);
                $("#TableToday").html(res.Table);
            }
        })
        .fail(function() {
            TableToday();
        });
}

var ShowViewData = function ShowViewData(e) {
    $('#Show_view_Data').modal('show');
    $("body").css("padding-right", "0");
    var Code = $(e).attr('code');
    var Name = $(e).attr('name');
    var Guset_in = $(e).attr('Guset_in');
    var Main_id = $(e).attr('main_id');
    var csrf = $('meta[name="csrf-token"]').attr('content');
    // Create From Data
    var Data = new FormData();
    // Data Put Array
    Data.append('_token', csrf);
    Data.append('Code', Code);
    Data.append('Name', Name);
    Data.append('Guset_in', Guset_in);
    Data.append('Main_id', Main_id);
    // Ajax Send Data
    $.ajax({
            url: 'ShowViewData',
            type: 'POST',
            dataType: 'text',
            cache: false,
            contentType: false,
            processData: false,
            data: Data,
            success: function(callback) {
                var res = jQuery.parseJSON(callback);
                $("#Show_view_Data_Table").html(res.Table);
            }
        })
        .fail(function() {
            ShowViewData();
        });
}

var ShowViewDataMain = function ShowViewDataMain(e) {
    $('#Show_view_Data').modal('show');
    $("body").css("padding-right", "0");
    var Code = $(e).attr('code');
    var Name = $(e).attr('name');
    var Guset_in = $(e).attr('Guset_in');
    var Main_id = $(e).attr('main_id');
    var csrf = $('meta[name="csrf-token"]').attr('content');
    // Create From Data
    var Data = new FormData();
    // Data Put Array
    Data.append('_token', csrf);
    Data.append('Code', Code);
    Data.append('Name', Name);
    Data.append('Guset_in', Guset_in);
    Data.append('Main_id', Main_id);
    // Ajax Send Data
    $.ajax({
            url: 'ShowViewDataMain',
            type: 'POST',
            dataType: 'text',
            cache: false,
            contentType: false,
            processData: false,
            data: Data,
            success: function(callback) {
                var res = jQuery.parseJSON(callback);
                $("#Show_view_Data_Table").html(res.Table);
            }
        })
        .fail(function() {
            ShowViewDataMain();
        });
}

var GoPostCodeEdit = function GoPostCodeEdit(e) {
    var csrf = $('meta[name="csrf-token"]').attr('content');
    var Code = $(e).attr('code');
    $.redirect("CheckIn", {_token: csrf, inputcode: Code}, "POST");
}
