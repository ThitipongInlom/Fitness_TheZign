$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
    Tableonlineforlogout();
});
var Tableonlineforlogout = function Tableonlineforlogout() {
    $.ajax({
            url: 'Tableonlineforlogout',
            success: function (callback) {
                var res = jQuery.parseJSON(callback);
                $("#Tableonlineforlogout").html(res.Table);
            }
        })
        .fail(function () {
            Tableonlineforlogout();
        });
}
var Showdatatologout = function Showdatatologout(e) {
    var csrf = $('meta[name="csrf-token"]').attr('content');
    var Main_id = $(e).attr('main_id');
    var Code = $(e).attr('code');
    var listid = $(e).attr('id');
    // Create From Data
    var Data = new FormData();
    // Data Put Array
    Data.append('_token', csrf);
    Data.append('Main_id', Main_id);
    Data.append('Code', Code);
    // Ajax Send Data
    $.ajax({
            url: 'Showdatatologout',
            type: 'POST',
            dataType: 'text',
            cache: false,
            contentType: false,
            processData: false,
            data: Data,
            success: function (callback) {
                var res = jQuery.parseJSON(callback);
                $("#Showdatatologout").html(res.Table);
            }
        })
        .fail(function () {
            Showdatatologout();
        });
}
var Dologout = function Dologout(e) {
    var csrf = $('meta[name="csrf-token"]').attr('content');
    var Main_id = $("#Main_idhidden").val();
    var Code = $("#codehidden").val();
    var Price = $("#pricehidden").val();
    var Priceformat = $("#pricehiddenformat").val();
    // Create From Data
    var Data = new FormData();
    // Data Put Array
    Data.append('_token', csrf);
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
    var csrf = $('meta[name="csrf-token"]').attr('content');
    var Main_id = $("#Main_idhidden").val();
    var Code = $("#codehidden").val();
    // Send Data Ajax To Query
    $.ajax({
            url: 'Dologout',
            type: 'POST',
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
