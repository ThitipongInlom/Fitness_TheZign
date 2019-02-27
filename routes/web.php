<?php

// Main Page
Route::get('/', function () {
    return view('Login');
});
// Fitness MainCheck
Route::get('/MainCheck', 'Main_Check@MainCheck');
// Fitness MainUsers
Route::get('/MainUsers', 'MainUsers@MainUsers');
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
// Report
Route::get('/Report', 'Report@Report');
// Dashboard
Route::get('/Dashboard', 'Choose_Main@Dashboard');
// Setting
Route::get('/Setting', 'Setting@Setting');
// Namesearching
Route::post('/Namesearching', 'Checkin@Namesearching');
// Table Display
Route::post('/TableDisplay', 'Checkin@TableDisplay');
// Table TablePane
Route::post('/TablePane', 'Checkin@TablePane');
// Insert Type L
Route::post('/Insert_type_L', 'Checkin@Insert_type_L');
// Insert Type C
Route::post('/Insert_type_C', 'Checkin@Insert_type_C');
// Insert Type P
Route::post('/Insert_type_P', 'Checkin@Insert_type_P');
// CheckInOnline
Route::post('/CheckInOnline', 'Checkin@CheckInOnline');
// Table Online
Route::get('/TableOnline', 'Main_Check@TableOnline');
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
// Edit_Number_Key
Route::post('/Edit_Number_Key', 'Checkin@Edit_Number_Key');
// Discount
Route::post('/Discount', 'Checkin@Discount');
// Discount_Save
Route::post('/Discount_Save', 'Checkin@Discount_Save');
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
// Modal_History_Package_Useing_Display
Route::post('/Modal_History_Package_Useing_Display', 'Checkin@Modal_History_Package_Useing_Display');
// DeleteOnusePackage
Route::post('/DeleteOnusePackage', 'Checkin@DeleteOnusePackage');
// Data Table
Route::post('/DataTable', 'MainUsers@Data');
// VoidItem
Route::post('/VoidItem', 'Checkin@VoidItem');
// VoidItem_modal
Route::post('/VoidItem_modal', 'Checkin@VoidItem_modal');
// ViewDataUser
Route::post('/ViewData', 'MainUsers@ViewData');
// Charge_modal
Route::post('/Charge_modal', 'Checkin@Charge_modal');
// ChargeItem
Route::post('/ChargeItem', 'Checkin@ChargeItem');
// Uploadimguser
Route::post('/Uploadimguser', 'MainUsers@Uploadimguser');
// Model_code_viewdata
Route::post('/Model_code_viewdata', 'MainUsers@Model_code_viewdata');
// Calculate_Day
Route::post('/Calculate_Day', 'MainUsers@Calculate_Day');
// GenerateWiFi
Route::post('/GenerateWiFi', 'MainUsers@GenerateWiFi');
// Report Tab 1
Route::post('/Report_tab_1', 'Report@Report_tab_1');
// Report Tab 2
Route::post('/Report_tab_2', 'Report@Report_tab_2');
// Airlink Modal Data
Route::post('/Airlink_modal_data', 'MainUsers@Airlink_modal_data');
// Send To Register
Route::post('/SendToRegister', 'MainUsers@SendToRegister');
// Calculate renewal
Route::post('/Calculate_renewal', 'MainUsers@Calculate_renewal');
// Table Tab 1
Route::post('/Table_tab_1', 'Setting@Table_tab_1');
// Check_K_bank
Route::get('/Check_K_bank', 'Choose_Main@Check_K_bank');
// StopMB
Route::post('/StopMB', 'MainUsers@StopMB');
// Edit Member
Route::post('/Edit_member', 'MainUsers@Edit_member');
// Remember_reconnent_airlink
Route::post('/Remember_reconnent_airlink', 'MainUsers@Remember_reconnent_airlink');
// Get Type Data
Route::post('/Get_type_data', 'Setting@Get_type_data');
// Save Add Data Type
Route::post('/Add_Data_Type', 'Setting@Add_Data_Type');
// Save Edit Data Type
Route::post('/Edit_Data_Type', 'Setting@Edit_Data_Type');
// Dev Create user
Route::get('/Create/{user}/{password}/{name}/{email}/{status}/{token}', 'Controller@Create_user_dev');
