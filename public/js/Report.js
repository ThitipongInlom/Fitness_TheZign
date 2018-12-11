var Showthb1 = function Showthb1() {
    // Create From Data
    var Data = new FormData();
    // Data Put Array
    Data.append('start', $("#Tab_1_start").val());
    Data.append('end', $("#Tab_1_end").val());
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
        success: function(callback) {
            var res = jQuery.parseJSON(callback);
            console.log(res);
            $("#Tab1_Display").html(res.Table);
        }
    });
}
