<?php

// Main Page
Route::get('/', function () {
    return view('Login');
});
// Fitness MainCheck
Route::get('/MainCheck', 'Main_Check@MainCheck');
// Fitness MainUsers
Route::get('/MainUsers', 'MainUsers@MainUsers');
// Fitness MainUsers
Route::get('/MainCovid', 'MainCovid@MainCovid');
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
// Life ring
Route::post('/Life_ring', 'Checkin@Life_ring');
// Edit_Other
Route::post('/Edit_Other', 'Checkin@Edit_Other');
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
// Data Table Covid
Route::post('/DataTableCovid', 'MainCovid@Data');
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
// Calculate_Day_Covid
Route::post('/Save_Viewdata_Covid', 'MainCovid@Save_Viewdata_Covid');
// GenerateWiFi
Route::post('/GenerateWiFi', 'MainUsers@GenerateWiFi');
// Report Tab 1
Route::post('/Report_tab_1', 'Report@Report_tab_1');
// Report Tab 2
Route::post('/Report_tab_2', 'Report@Report_tab_2');
// Report Tab 3
Route::post('/Report_tab_3', 'Report@Report_tab_3');
// Report Tab 4
Route::post('/Report_tab_4', 'Report@Report_tab_4');
// Airlink Modal Data
Route::post('/Airlink_modal_data', 'MainUsers@Airlink_modal_data');
// Send To Register
Route::post('/SendToRegister', 'MainUsers@SendToRegister');
// Calculate renewal
Route::post('/Calculate_renewal', 'MainUsers@Calculate_renewal');
// Table Tab 1
Route::post('/Table_tab_1', 'Setting@Table_tab_1');
// Table_trainner
Route::post('/Table_trainner', 'Setting@Table_trainner');
// Table_trainner_emp
Route::post('/Table_trainner_emp', 'Setting@Table_trainner_emp');
// Table_item
Route::post('/Table_item', 'Setting@Table_item');
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
// Get_Trainner_emp_data
Route::post('/Get_Trainner_emp_data', 'Setting@Get_Trainner_emp_data');
// Save Add Data Type
Route::post('/Add_Data_Type', 'Setting@Add_Data_Type');
// Save Edit Data Type
Route::post('/Edit_Data_Type', 'Setting@Edit_Data_Type');
// Closeday 
Route::get('/Insert_Closeday', 'Closeday@Index_Closeday');
// Save_trainner
Route::post('/Save_trainner', 'Setting@Save_trainner');
// Save_trainner_edit
Route::post('/Save_trainner_edit', 'Setting@Save_trainner_edit');
// Delete_trainner
Route::post('/Delete_trainner', 'Setting@Delete_trainner');
// Auto_Generate_wifi
Route::get('/Auto_Generate_wifi', 'MainUsers@Auto_Generate_wifi');
// Get_data_trainner
Route::post('Get_data_trainner','Setting@Get_data_trainner');
// Save_Trainner_emp
Route::post('/Save_Trainner_emp', 'Setting@Save_Trainner_emp');
// Save_edit_Trainner_emp
Route::post('/Save_edit_Trainner_emp', 'Setting@Save_edit_Trainner_emp');
// Select_trianner_emp
Route::post('/Select_trianner_emp', 'Setting@Select_trianner_emp');
// Display_select_trainner_emp
Route::post('/Display_select_trainner_emp', 'Checkin@Display_select_trainner_emp_model');
// Display_select_trainner_emp_edit
Route::post('/Display_select_trainner_emp_edit', 'Checkin@Display_select_trainner_emp_model_edit');
// Save_select_trainner_emp
Route::post('/Save_select_trainner_emp_to_member', 'Checkin@Save_select_trainner_emp_to_member');
// Save_select_trainner_emp_edit
Route::post('/Save_select_trainner_emp_to_member_edit', 'Checkin@Save_select_trainner_emp_to_member_edit');
// Display_select_trainner_class
Route::post('/Display_select_trainner_class', 'Checkin@Display_select_trainner_class_model');
// Save_select_trainner_emp
Route::post('/Save_select_trainner_class_to_member', 'Checkin@Save_select_trainner_class_to_member');
// API Auto Trainner
Route::get('/Auto_Check_and_insert_trainner', 'Setting@Auto_Check_and_insert_trainner');
// API Get Trainner
Route::post('/API_Trainner', 'Report@API_Trainner');
// API onchange_switch_type
Route::post('/onchange_switch_type', 'Setting@onchange_switch_type');
// API Auto Genpassword airlink 
Route::get('/Auto_Genpassword_airlink', 'MainUsers@Auto_Genpassword_airlink');
// Dev Create user
Route::get('/Create/{user}/{password}/{name}/{email}/{status}/{token}', 'Controller@Create_user_dev');
// Upload_member_document
Route::post('/Upload_member_document', 'MainUsers@Upload_member_document');
// Api Get Table document 
Route::post('/Get_Table_document', 'MainUsers@Get_Table_document');
