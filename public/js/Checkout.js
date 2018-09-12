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
	});	
}
var Dologout = function Dologout(e) {
	var csrf = $('meta[name="csrf-token"]').attr('content');
	var Main_id = $(e).attr('main_id');
	var Code = $(e).attr('code');
	// Create From Data
	var Data = new FormData();
	// Data Put Array
	Data.append('_token', csrf);	
	Data.append('Main_id', Main_id);
	Data.append('Code', Code);
	// Ajax Send Data	
	$.ajax({
		url: 'Dologout',
		type: 'POST',
		dataType: 'text',
        cache: false,
        contentType: false,
        processData: false,		
		data: Data,
		success: function (callback) {
			$.redirect("MainCheck", {}, "GET");
		}
	});
	
}