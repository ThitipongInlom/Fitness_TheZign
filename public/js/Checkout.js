$(document).ready(function() {
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
	});	
}
var Showdatatologout = function Showdatatologout(e) {
	var csrf = $('meta[name="csrf-token"]').attr('content');
	var Main_id = $(e).attr('main_id');
	var Code    = $(e).attr('code');
	var listid  = $(e).attr('id');
	$.ajax({
		url: 'Showdatatologout',
		type: 'POST',
		data: {_token: csrf, Main_id: Main_id, Code: Code},
		success: function (callback) {
			var res = jQuery.parseJSON(callback);
			$("#Showdatatologout").html(res.Table);	
		}
	});	
}
var Dologout = function Dologout(e) {
	var csrf = $('meta[name="csrf-token"]').attr('content');
	var Main_id = $(e).attr('main_id');
	var Code = $(e).attr('code');
	$.ajax({
		url: 'Dologout',
		type: 'POST',
		data: {_token: csrf,Main_id: Main_id,Code: Code},
		success: function (callback) {
			$.redirect("MainCheck", {}, "GET");
		}
	});
	
}