<?php

// Main Page
Route::get('/', function () {
    return view('Login');
});
// Fitness MainCheck
Route::get('/MainCheck', 'Main_Check@MainCheck');
// Check In Page
Route::get('/CheckIn', 'Checkin@CheckInPage');
// Check In Processor
Route::post('/CheckIn', 'Checkin@CheckInProcessor');
// Check Out Page
Route::get('/CheckOut', 'Checkout@CheckOutPage');
// Do_Login
Route::post('/Do_login', 'Controller@Do_login');
// Logout
Route::get('/Logout', 'Controller@Logout');
// Dashboard
Route::get('/Dashboard', 'Choose_Main@Dashboard');
// Namesearching
Route::post('/Namesearching', 'Checkin@Namesearching');
// Table Display
Route::post('/TableDisplay', 'Checkin@TableDisplay');
// Table TablePane
Route::post('/TablePane', 'Checkin@TablePane');
// Insert Type L
Route::post('/Insert_type_L', 'Checkin@Insert_type_L');
// Insert Type P
Route::post('/Insert_type_P', 'Checkin@Insert_type_P');
// CheckInOnline
Route::post('/CheckInOnline', 'Checkin@CheckInOnline');
// Table Online
Route::get('/TableOnline', 'Main_Check@TableOnline');
// Table Yesterday
Route::get('/TableYesterday', 'Main_Check@TableYesterday');
// Table TableToday
Route::get('/TableToday', 'Main_Check@TableToday');
// ShowViewDatas
Route::post('/ShowViewData', 'Main_Check@ShowViewData');
// ShowViewDataMain
Route::post('/ShowViewDataMain', 'Main_Check@ShowViewDataMain');
// Tableonlineforlogout
Route::get('/Tableonlineforlogout', 'Checkout@Tableonlineforlogout');
// Showdatatologout 
Route::post('/Showdatatologout' , 'Checkout@Showdatatologout');
// Dologout
Route::post('/Dologout', 'Checkout@Dologout');
// Edit_Number
Route::post('/Edit_Number', 'Checkin@EditNumber');
// Delete_item
Route::post('/Delete_item', 'Checkin@Delete_item');
// Delete_item_time
Route::post('/Delete_item_time', 'Checkin@Delete_item_time');
// Foronchangenum 
Route::post('/Foronchangenum', 'Checkin@Foronchangenum');
// History
Route::post('/History', 'Checkin@History');
// DisplayPackage
Route::post('/DisplayPackage', 'Checkin@DisplayPackage');
// PackageItem
Route::post('/PackageItem', 'Checkin@PackageItem');
// OnUsePackage
Route::post('/OnUsePackage', 'Checkin@OnUsePackage');
// PackageOnuseDisplay
Route::post('/PackageOnuseDisplay', 'Checkin@PackageOnuseDisplay');