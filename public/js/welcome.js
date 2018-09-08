$(document).ready(function() {
	$('[data-toggle="tooltip"]').tooltip();
	setTimeout(function() {
	OnlineTable();	
	}, 10);
	setTimeout(function() {
	TableYesterday();	
	}, 20);
	setTimeout(function () {
	TableToday();
	}, 30);
});

var OnlineTable = function OnlineTable() {
	$.ajax({
		url: 'TableOnline',
		type: 'GET',
		success: function (callback) {
			var res = jQuery.parseJSON(callback);
			$("#TableOnline").html(res.Table);	
		}
	});
}

var TableYesterday = function TableYesterday() {
	$.ajax({
		url: 'TableYesterday',
		type: 'GET',
		success: function (callback) {
			var res = jQuery.parseJSON(callback);
			$("#TableYesterday").html(res.Table);	
		}
	});
}

var TableToday = function TableToday() {
	$.ajax({
		url: 'TableToday',
		type: 'GET',
		success: function (callback) {
			var res = jQuery.parseJSON(callback);
			$("#TableToday").html(res.Table);	
		}
	});
}

var ShowViewData = function ShowViewData(e) {
	var Code = $(e).attr('code');
	var Name = $(e).attr('name');
	var Guset_in = $(e).attr('Guset_in');
	var Main_id  = $(e).attr('main_id');
	var csrf = $('meta[name="csrf-token"]').attr('content');
	$.ajax({
		url: 'ShowViewData',
		type: 'POST',
		data: {_token: csrf,Code: Code,Name: Name,Guset_in: Guset_in,Main_id: Main_id},
		success: function (callback) {
			var res = jQuery.parseJSON(callback);
			$("#Show_view_Data_Table").html(res.Table);
		}
	});
}

var ShowViewDataMain = function ShowViewDataMain(e) {
	var Code = $(e).attr('code');
	var Name = $(e).attr('name');
	var Guset_in = $(e).attr('Guset_in');
	var Main_id  = $(e).attr('main_id');
	var csrf = $('meta[name="csrf-token"]').attr('content');
	$.ajax({
		url: 'ShowViewDataMain',
		type: 'POST',
		data: {_token: csrf,Code: Code,Name: Name,Guset_in: Guset_in,Main_id: Main_id},
		success: function (callback) {
			var res = jQuery.parseJSON(callback);
			$("#Show_view_Data_Table").html(res.Table);
		}
	});
}