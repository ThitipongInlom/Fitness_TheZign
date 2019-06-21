$(document).ready(function () {
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        if (e.target.hash == "#tab_3") {
            $.ajax({
                url: 'API_Trainner',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (callback) {
                    var res = jQuery.parseJSON(callback);
                    $("#Tab_3_select").html(res.option);
                }
            });
        }
    });
});

var Showthb1 = function Showthb1() {
    // Create From Data
    var Data = new FormData();
    // Data Put Array
    Data.append('range_date', $("#Tab_1_date").val());
    $.ajax({
        url: 'Report_tab_1',
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
            $("#Tab1_Display").html(res.Table);
        }
    });
}

var Showthb2 = function Showthb2() {
    // Create From Data
    var Data = new FormData();
    // Data Put Array
    Data.append('range_date', $("#Tab_2_date").val());
    Data.append('select', $("#Tab_2_select").val());
    $.ajax({
        url: 'Report_tab_2',
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
            $("#Tab2_Display").html(res.Table);
        }
    });
}

var Showthb3 = function Showthb3() {
    // Create From Data
    var Data = new FormData();
    // Data Put Array
    Data.append('range_date', $("#Tab_3_date").val());
    Data.append('select_name', $("#Tab_3_select").val());
    Data.append('select_class', $("#Tab_3_select_class").val());
    $.ajax({
        url: 'Report_tab_3',
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
            $("#Tab3_Display").html(res.Table);
        }
    });
}

var printElement = function printElement(elem) {
    var domClone = elem.cloneNode(true);
    var $printSection = document.getElementById("printSection");
    if (!$printSection) {
        var $printSection = document.createElement("div");
        $printSection.id = "printSection";
        document.body.appendChild($printSection);
    }
    $printSection.innerHTML = "";
    $printSection.appendChild(domClone);
    window.print();
    $printSection.innerHTML = "";
}
