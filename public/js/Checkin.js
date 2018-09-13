$(document).ready(function() {
   	$('[data-toggle="tooltip"]').tooltip(); 
    $('#Find_the_name').on('show.bs.modal', function (e) {
    	$("#namesearching").attr('disabled', '');
		$("#namesearchingstatus").html('<span class="badge badge-secondary" style="margin-top: 10px;">เลือกประเภทที่จะค้นหา</span>');
	});
	$('#Find_the_name').on('hidden.bs.modal', function (e) {
		$("#namesearching").val('');
		$("#table_find_name").html('');
	});	
	// Ajax Get Data TO Fake Data
	setTimeout(function() {
	DisplayTable();	
	}, 100);
	setTimeout(function() {
	TablePane();
	}, 200);
	setTimeout(function() {
	DisplayPackage();
	}, 300);
	setTimeout(function() {
	PackageItem();
	}, 400);
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
	var csrf = $('meta[name="csrf-token"]').attr('content');
	// Create From Data
	var Data = new FormData();
	// Data Put Array
	Data.append('_token', csrf);
	Data.append('name', name);
	Data.append('status', status);
	$.ajax({
		url: 'Namesearching',
		type: 'POST',
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
	setTimeout(function() {
		$.redirect("CheckIn", {_token: csrf, inputcode: code}, "POST");
	}, 500);
}

var CheckInOnline = function CheckInOnline(e) {
	var csrf = $('meta[name="csrf-token"]').attr('content');
	var Code = $("#codehidden").val();
	$.ajax({
		url: 'CheckInOnline',
		type: 'POST',
		data: {_token: csrf,Code: Code},
		success: function (res) {
		$.redirect("MainCheck", {}, "GET");
		}
	});
}

var Item_To_Disktop = function Item_To_Disktop(e) {
	// Check Code
	var Code = $("#codehidden").val();
	var csrf = $('meta[name="csrf-token"]').attr('content');
	// Check Type 
	var Item_code = $(e).attr('item_code');
	var Item_type = $(e).attr('item_type');
	var Item_name = $(e).attr('item_name');
	var Item_price= $(e).attr('item_price');
	var Item_codetype = $(e).attr('item_codetype');
	var Item_setnumber = $(e).attr('item_setnumber');
	// Create From Data
	var Data = new FormData();
	// Data Put Array
	Data.append('_token', csrf);	
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
		dataType: 'text',
        cache: false,
        contentType: false,
        processData: false,		
		data: Data,
	});
	}
	// Type C  == Course
	if (Item_type == 'C') {
	console.log(Data);
	}
	// Type P  == Package
	if (Item_type == 'P') {
	$.ajax({
		url: 'Insert_type_P',
		type: 'POST',
		dataType: 'text',
        cache: false,
        contentType: false,
        processData: false,		
		data: Data,
	});
	
	}
	// Display Hide
	$("#DisplayItemList").addClass("flipOutX");
	$("#DisplayItemList").html('');
	// Ajax Get Data TO Fake Data
	setTimeout(function() {
	DisplayTable();	
	DisplayPackage();
	PackageItem();
	}, 200);
}

var DisplayTable = function DisplayTable() {
	// Check Code
	var Code = $("#codehidden").val();
	var csrf = $('meta[name="csrf-token"]').attr('content');
	// Create From Data
	var Data = new FormData();
	// Data Put Array
	Data.append('_token', csrf);	
	Data.append('Code', Code);	
	// Ajax Get Data TO Fake Data	
	$.ajax({
		url: 'TableDisplay',
		type: 'POST',
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
	.fail(function() {
		DisplayTable();
	});
}

var TablePane = function TablePane() {
	// Check Code
	var Code = $("#codehidden").val();
	var csrf = $('meta[name="csrf-token"]').attr('content');
	// Create From Data
	var Data = new FormData();
	// Data Put Array
	Data.append('_token', csrf);	
	Data.append('Code', Code);		
	// Ajax Get Data TO Fake Data
	$.ajax({
		url: 'TablePane',
		type: 'POST',
		dataType: 'text',
        cache: false,
        contentType: false,
        processData: false,		
		data: Data,
		success:function (callback) {
			var res = jQuery.parseJSON(callback);
			$("#PaneItem").html(res.Navtab);
		}
	})
	.fail(function() {
		TablePane();
	});
}

var Edit_Number = function Edit_Number(e) {
	// Modal Show
	$('#Edit_Number').modal('show');
	// Data SetToSend
	var Fake_table_id = $(e).attr('fake_table_id');
	var csrf = $('meta[name="csrf-token"]').attr('content');
	// Create From Data
	var Data = new FormData();
	// Data Put Array
	Data.append('_token', csrf);	
	Data.append('Fake_table_id', Fake_table_id);	
	// Ajax To Send
	$.ajax({
		url: 'Edit_Number',
		type: 'POST',
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

var Delete_item = function Delete_item(e) {
	// Data SetToSend
	var Fake_table_id = $(e).attr('fake_table_id');
	var csrf = $('meta[name="csrf-token"]').attr('content');
	// Create From Data
	var Data = new FormData();
	// Data Put Array
	Data.append('_token', csrf);	
	Data.append('Fake_table_id', Fake_table_id);	
	// Ajax To Send
	$.ajax({
		url: 'Delete_item',
		type: 'POST',
		dataType: 'text',
        cache: false,
        contentType: false,
        processData: false,		
		data: Data,
		success: function (callback) {
			setTimeout(function() {
			DisplayTable();	
			}, 10);
		}
	});
}

var Delete_item_time = function Delete_item_time(e) {
	// Data SetToSend
	var Fake_table_id = $(e).attr('fake_table_id');
	var csrf = $('meta[name="csrf-token"]').attr('content');
	// Create From Data
	var Data = new FormData();
	// Data Put Array
	Data.append('_token', csrf);	
	Data.append('Fake_table_id', Fake_table_id);	
	// Ajax To Send
	$.ajax({
		url: 'Delete_item_time',
		type: 'POST',
		dataType: 'text',
        cache: false,
        contentType: false,
        processData: false,		
		data: Data,
		success: function (callback) {
			setTimeout(function() {
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
	var csrf = $('meta[name="csrf-token"]').attr('content');
	// Create From Data
	var Data = new FormData();
	// Data Put Array
	Data.append('_token', csrf);	
	Data.append('Fake_table_id', Fake_table_id);
	Data.append('NewNum', NewNum);	
	// Ajax To Send
	$.ajax({
		url: 'Foronchangenum',
		type: 'POST',
		dataType: 'text',
        cache: false,
        contentType: false,
        processData: false,		
		data: Data,
		success: function (callback) {
			setTimeout(function() {
			// Modal Hide
			$('#Edit_Number').modal('hide');
			DisplayTable();	
			}, 10);
		}
	});
}

var History = function History() {
	// Get Code
	var Code = $("#codehidden").val();
	var csrf = $('meta[name="csrf-token"]').attr('content');
	// Create From Data
	var Data = new FormData();
	// Data Put Array
	Data.append('_token', csrf);	
	Data.append('Code', Code);	
	// Modal Show
	$('#History').modal('show');	
	// Ajax Get Data To Table
	$.ajax({
		url: 'History',
		type: 'POST',
		dataType: 'text',
        cache: false,
        contentType: false,
        processData: false,		
		data: Data,
		success: function (callback) {
			$("#History_display").html(callback);
		}
	})
	.fail(function() {
		History();
	});
}

var DisplayPackage = function DisplayPackage() {
	// Get Code
	var Code = $("#codehidden").val();
	var csrf = $('meta[name="csrf-token"]').attr('content');
	// Create From Data
	var Data = new FormData();
	// Data Put Array
	Data.append('_token', csrf);	
	Data.append('Code', Code);	
	// Ajax Send Data
	$.ajax({
		url: 'DisplayPackage',
		type: 'POST',
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
	.fail(function() {
		DisplayPackage();
	});
}

var PackageItem = function PackageItem() {
	// Get Code
	var Code = $("#codehidden").val();
	var csrf = $('meta[name="csrf-token"]').attr('content');
	// Create From Data
	var Data = new FormData();
	// Data Put Array
	Data.append('_token', csrf);	
	Data.append('Code', Code);		
	// Ajax Send Data
	$.ajax({
		url: 'PackageItem',
		type: 'POST',
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
	.fail(function() {
		PackageItem();
	});
}

