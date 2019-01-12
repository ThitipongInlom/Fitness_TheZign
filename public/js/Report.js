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
            $("#Tab1_Display").html(res.Table);
        }
    });
}

var Showthb2 = function Showthb2() {
    // Create From Data
    var Data = new FormData();
    // Data Put Array
    Data.append('start', $("#Tab_2_start").val());
    Data.append('end', $("#Tab_2_end").val());
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
        success: function(callback) {
            var res = jQuery.parseJSON(callback);
            $("#Tab2_Display").html(res.Table);
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
