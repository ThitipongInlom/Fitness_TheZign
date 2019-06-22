<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB as DB;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Main_Check extends Controller
{
	public function MainCheck()
	{
		return view('MainCheck');
	}

	public function TableOnline()
	{
		$DataCode = DB::table('main_table')
									->select(DB::raw('*, LEFT(Name, 10) AS Nameshot'))
									->where('Status', 'IN')->get();
		// Table
		$Table = '
            <table class="table table-sm animated bounceIn" id="TableOnlineDatatable">
              <thead>
                <tr align="center">
                  <th scope="col">No.</th>
                  <th scope="col">Code</th>
                  <th scope="col">Name (CheckIn)</th>
                  <th scope="col">Action</th>
                </tr>
              </thead><tbody style="font-size: 14px;">';

            $i = 0;
            foreach ($DataCode as $key => $row) {
            $i++;
			$Showkey_onuse_count = DB::table('fake_table')->where('main_id', $row->ID)->where('Fake_itemcode', 'P14')->limit(5)->count();
			$Showkey_onuse = DB::table('fake_table')->where('main_id', $row->ID)->where('Fake_itemcode', 'P14')->limit(5)->get();
			$Class_show = DB::table('fake_table')->where('main_id', $row->ID)->where('Fake_itemtype', 'C')->limit(1)->get();
			if (isset($Class_show[0]->Fake_itemname)) {
				$Class = "( <i class='fas fa-walking'></i>".$Class_show[0]->Fake_itemname." )";
			}else {
				$Class = "";
			}
			$ModifyTimeOnline = date("H:i" , strtotime($row->Guset_in));
			$GuestHotel = DB::table('member')->where('code', $row->Code)->get();
			if ($Showkey_onuse_count == '1') {
			if ($GuestHotel[0]->type == 'Hotel') {
			$Table .= "
	                <tr align='center'>
	                  <td>$i</td>
	                  <td>$row->Code</td>
	                  <td align='left'><span style='cursor: pointer;' data-toggle='tooltip' data-placement='top' title='$row->Name'>$row->Nameshot... ($ModifyTimeOnline)</span>  (<i class='fas fa-key'></i> ". $Showkey_onuse[0]->Fake_sum .") (<i class='fas fa-door-open'></i> ". $GuestHotel[0]->wifipassword .") $Class</td>
	                  <td>
	                  <button class='btn btn-sm btn-primary' onclick='ShowViewData(this)' main_id='$row->ID' code='$row->Code' name='$row->Name' Guset_in='$row->Guset_in' data-toggle='tooltip' data-placement='bottom' title='ดูรายการ'><i class='fas fa-search'></i></button>
	                  <button class='btn btn-sm btn-secondary' onclick='GoPostCodeEdit(this)' code='$row->Code' data-toggle='tooltip' data-placement='bottom' title='แก้ไขรายการ'><i class='fas fa-edit'></i></button>
	                  </td>
					</tr>";
			}else{
			$Table .= "
	                <tr align='center'>
	                  <td>$i</td>
	                  <td>$row->Code</td>
	                  <td align='left'><span style='cursor: pointer;' data-toggle='tooltip' data-placement='top' title='$row->Name'>$row->Nameshot... ($ModifyTimeOnline)</span>  (<i class='fas fa-key'></i> ". $Showkey_onuse[0]->Fake_sum .") $Class</td>
	                  <td>
	                  <button class='btn btn-sm btn-primary' onclick='ShowViewData(this)' main_id='$row->ID' code='$row->Code' name='$row->Name' Guset_in='$row->Guset_in' data-toggle='tooltip' data-placement='bottom' title='ดูรายการ'><i class='fas fa-search'></i></button>
	                  <button class='btn btn-sm btn-secondary' onclick='GoPostCodeEdit(this)' code='$row->Code' data-toggle='tooltip' data-placement='bottom' title='แก้ไขรายการ'><i class='fas fa-edit'></i></button>
	                  </td>
					</tr>";
			}
			}elseif ($Showkey_onuse_count == '2') {
			if ($GuestHotel[0]->type == 'Hotel') {
			$Table .= "
	                <tr align='center'>
	                  <td>$i</td>
	                  <td>$row->Code</td>
	                  <td align='left'><span style='cursor: pointer;' data-toggle='tooltip' data-placement='top' title='$row->Name'>$row->Nameshot... ($ModifyTimeOnline)</span>  (<i class='fas fa-key'></i> ". $Showkey_onuse[0]->Fake_sum .") (<i class='fas fa-key'></i>". $Showkey_onuse[1]->Fake_sum .") (<i class='fas fa-door-open'></i> ". $GuestHotel[0]->wifipassword .") $Class</td>
	                  <td>
	                  <button class='btn btn-sm btn-primary' onclick='ShowViewData(this)' main_id='$row->ID' code='$row->Code' name='$row->Name' Guset_in='$row->Guset_in' data-toggle='tooltip' data-placement='bottom' title='ดูรายการ'><i class='fas fa-search'></i></button>
	                  <button class='btn btn-sm btn-secondary' onclick='GoPostCodeEdit(this)' code='$row->Code' data-toggle='tooltip' data-placement='bottom' title='แก้ไขรายการ'><i class='fas fa-edit'></i></button>
	                  </td>
					</tr>";							
			}else{
			$Table .= "
	                <tr align='center'>
	                  <td>$i</td>
	                  <td>$row->Code</td>
	                  <td align='left'><span style='cursor: pointer;' data-toggle='tooltip' data-placement='top' title='$row->Name'>$row->Nameshot... ($ModifyTimeOnline)</span>  (<i class='fas fa-key'></i> ". $Showkey_onuse[0]->Fake_sum .") (<i class='fas fa-key'></i>". $Showkey_onuse[1]->Fake_sum .") $Class</td>
	                  <td>
	                  <button class='btn btn-sm btn-primary' onclick='ShowViewData(this)' main_id='$row->ID' code='$row->Code' name='$row->Name' Guset_in='$row->Guset_in' data-toggle='tooltip' data-placement='bottom' title='ดูรายการ'><i class='fas fa-search'></i></button>
	                  <button class='btn btn-sm btn-secondary' onclick='GoPostCodeEdit(this)' code='$row->Code' data-toggle='tooltip' data-placement='bottom' title='แก้ไขรายการ'><i class='fas fa-edit'></i></button>
	                  </td>
					</tr>";
			}
			}elseif ($Showkey_onuse_count == '3') {
			if ($GuestHotel[0]->type == 'Hotel') {
			$Table .= "
	                <tr align='center'>
	                  <td>$i</td>
	                  <td>$row->Code</td>
	                  <td align='left'><span style='cursor: pointer;' data-toggle='tooltip' data-placement='top' title='$row->Name'>$row->Nameshot... ($ModifyTimeOnline)</span>  (<i class='fas fa-key'></i> ". $Showkey_onuse[0]->Fake_sum .") (<i class='fas fa-key'></i> ". $Showkey_onuse[1]->Fake_sum .") (<i class='fas fa-key'></i> ". $Showkey_onuse[2]->Fake_sum .") (<i class='fas fa-door-open'></i> ". $GuestHotel[0]->wifipassword .") $Class</td>
	                  <td>
	                  <button class='btn btn-sm btn-primary' onclick='ShowViewData(this)' main_id='$row->ID' code='$row->Code' name='$row->Name' Guset_in='$row->Guset_in' data-toggle='tooltip' data-placement='bottom' title='ดูรายการ'><i class='fas fa-search'></i></button>
	                  <button class='btn btn-sm btn-secondary' onclick='GoPostCodeEdit(this)' code='$row->Code' data-toggle='tooltip' data-placement='bottom' title='แก้ไขรายการ'><i class='fas fa-edit'></i></button>
	                  </td>
					</tr>";								
			}else{
			$Table .= "
	                <tr align='center'>
	                  <td>$i</td>
	                  <td>$row->Code</td>
	                  <td align='left'><span style='cursor: pointer;' data-toggle='tooltip' data-placement='top' title='$row->Name'>$row->Nameshot... ($ModifyTimeOnline)</span>  (<i class='fas fa-key'></i> ". $Showkey_onuse[0]->Fake_sum .") (<i class='fas fa-key'></i> ". $Showkey_onuse[1]->Fake_sum .") (<i class='fas fa-key'></i> ". $Showkey_onuse[2]->Fake_sum .") $Class</td>
	                  <td>
	                  <button class='btn btn-sm btn-primary' onclick='ShowViewData(this)' main_id='$row->ID' code='$row->Code' name='$row->Name' Guset_in='$row->Guset_in' data-toggle='tooltip' data-placement='bottom' title='ดูรายการ'><i class='fas fa-search'></i></button>
	                  <button class='btn btn-sm btn-secondary' onclick='GoPostCodeEdit(this)' code='$row->Code' data-toggle='tooltip' data-placement='bottom' title='แก้ไขรายการ'><i class='fas fa-edit'></i></button>
	                  </td>
					</tr>";
			}
			}elseif ($Showkey_onuse_count == '4') {
			if ($GuestHotel[0]->type == 'Hotel') {
			$Table .= "
	                <tr align='center'>
	                  <td>$i</td>
	                  <td>$row->Code</td>
	                  <td align='left'><span style='cursor: pointer;' data-toggle='tooltip' data-placement='top' title='$row->Name'>$row->Nameshot... ($ModifyTimeOnline)</span>  (<i class='fas fa-key'></i> ". $Showkey_onuse[0]->Fake_sum .") (<i class='fas fa-key'></i> ". $Showkey_onuse[1]->Fake_sum .") (<i class='fas fa-key'></i> ". $Showkey_onuse[2]->Fake_sum .") (<i class='fas fa-key'></i> ". $Showkey_onuse[3]->Fake_sum .") (<i class='fas fa-door-open'></i> ". $GuestHotel[0]->wifipassword .") $Class</td>
	                  <td>
	                  <button class='btn btn-sm btn-primary' onclick='ShowViewData(this)' main_id='$row->ID' code='$row->Code' name='$row->Name' Guset_in='$row->Guset_in' data-toggle='tooltip' data-placement='bottom' title='ดูรายการ'><i class='fas fa-search'></i></button>
	                  <button class='btn btn-sm btn-secondary' onclick='GoPostCodeEdit(this)' code='$row->Code' data-toggle='tooltip' data-placement='bottom' title='แก้ไขรายการ'><i class='fas fa-edit'></i></button>
	                  </td>
					</tr>";							
			}else{
			$Table .= "
	                <tr align='center'>
	                  <td>$i</td>
	                  <td>$row->Code</td>
	                  <td align='left'><span style='cursor: pointer;' data-toggle='tooltip' data-placement='top' title='$row->Name'>$row->Nameshot... ($ModifyTimeOnline)</span>  (<i class='fas fa-key'></i> ". $Showkey_onuse[0]->Fake_sum .") (<i class='fas fa-key'></i> ". $Showkey_onuse[1]->Fake_sum .") (<i class='fas fa-key'></i> ". $Showkey_onuse[2]->Fake_sum .") (<i class='fas fa-key'></i> ". $Showkey_onuse[3]->Fake_sum .") $Class</td>
	                  <td>
	                  <button class='btn btn-sm btn-primary' onclick='ShowViewData(this)' main_id='$row->ID' code='$row->Code' name='$row->Name' Guset_in='$row->Guset_in' data-toggle='tooltip' data-placement='bottom' title='ดูรายการ'><i class='fas fa-search'></i></button>
	                  <button class='btn btn-sm btn-secondary' onclick='GoPostCodeEdit(this)' code='$row->Code' data-toggle='tooltip' data-placement='bottom' title='แก้ไขรายการ'><i class='fas fa-edit'></i></button>
	                  </td>
					</tr>";
			}
			}elseif ($Showkey_onuse_count == '5') {
			if ($GuestHotel[0]->type == 'Hotel') {
			$Table .= "
	                <tr align='center'>
	                  <td>$i</td>
	                  <td>$row->Code</td>
	                  <td align='left'><span style='cursor: pointer;' data-toggle='tooltip' data-placement='top' title='$row->Name'>$row->Nameshot... ($ModifyTimeOnline)</span>  (<i class='fas fa-key'></i> ". $Showkey_onuse[0]->Fake_sum .") (<i class='fas fa-key'></i> ". $Showkey_onuse[1]->Fake_sum .") (<i class='fas fa-key'></i> ". $Showkey_onuse[2]->Fake_sum .") (<i class='fas fa-key'></i> ". $Showkey_onuse[3]->Fake_sum .") (<i class='fas fa-key'></i> ". $Showkey_onuse[4]->Fake_sum .") (<i class='fas fa-door-open'></i> ". $GuestHotel[0]->wifipassword .") $Class</td>
	                  <td>
	                  <button class='btn btn-sm btn-primary' onclick='ShowViewData(this)' main_id='$row->ID' code='$row->Code' name='$row->Name' Guset_in='$row->Guset_in' data-toggle='tooltip' data-placement='bottom' title='ดูรายการ'><i class='fas fa-search'></i></button>
	                  <button class='btn btn-sm btn-secondary' onclick='GoPostCodeEdit(this)' code='$row->Code' data-toggle='tooltip' data-placement='bottom' title='แก้ไขรายการ'><i class='fas fa-edit'></i></button>
	                  </td>
					</tr>";								
			}else{
			$Table .= "
	                <tr align='center'>
	                  <td>$i</td>
	                  <td>$row->Code</td>
	                  <td align='left'><span style='cursor: pointer;' data-toggle='tooltip' data-placement='top' title='$row->Name'>$row->Nameshot... ($ModifyTimeOnline)</span>  (<i class='fas fa-key'></i> ". $Showkey_onuse[0]->Fake_sum .") (<i class='fas fa-key'></i> ". $Showkey_onuse[1]->Fake_sum .") (<i class='fas fa-key'></i> ". $Showkey_onuse[2]->Fake_sum .") (<i class='fas fa-key'></i> ". $Showkey_onuse[3]->Fake_sum .") (<i class='fas fa-key'></i> ". $Showkey_onuse[4]->Fake_sum .") $Class</td>
	                  <td>
	                  <button class='btn btn-sm btn-primary' onclick='ShowViewData(this)' main_id='$row->ID' code='$row->Code' name='$row->Name' Guset_in='$row->Guset_in' data-toggle='tooltip' data-placement='bottom' title='ดูรายการ'><i class='fas fa-search'></i></button>
	                  <button class='btn btn-sm btn-secondary' onclick='GoPostCodeEdit(this)' code='$row->Code' data-toggle='tooltip' data-placement='bottom' title='แก้ไขรายการ'><i class='fas fa-edit'></i></button>
	                  </td>
					</tr>";
			}
			}else{
			if ($GuestHotel[0]->type == 'Hotel') { 
			$Table .= "
	                <tr align='center'>
	                  <td>$i</td>
	                  <td>$row->Code</td>
	                  <td align='left'><span style='cursor: pointer;' data-toggle='tooltip' data-placement='top' title='$row->Name'>$row->Nameshot... ($ModifyTimeOnline)</span> (<i class='fas fa-door-open'></i> ". $GuestHotel[0]->wifipassword .") $Class</td>
	                  <td>
	                  <button class='btn btn-sm btn-primary' onclick='ShowViewData(this)' main_id='$row->ID' code='$row->Code' name='$row->Name' Guset_in='$row->Guset_in' data-toggle='tooltip' data-placement='bottom' title='ดูรายการ'><i class='fas fa-search'></i></button>
	                  <button class='btn btn-sm btn-secondary' onclick='GoPostCodeEdit(this)' code='$row->Code' data-toggle='tooltip' data-placement='bottom' title='แก้ไขรายการ'><i class='fas fa-edit'></i></button>
	                  </td>
					</tr>";
			}else{
			$Table .= "
	                <tr align='center'>
	                  <td>$i</td>
	                  <td>$row->Code</td>
	                  <td align='left'><span style='cursor: pointer;' data-toggle='tooltip' data-placement='top' title='$row->Name'>$row->Nameshot... ($ModifyTimeOnline)</span> $Class</td>
	                  <td>
	                  <button class='btn btn-sm btn-primary' onclick='ShowViewData(this)' main_id='$row->ID' code='$row->Code' name='$row->Name' Guset_in='$row->Guset_in' data-toggle='tooltip' data-placement='bottom' title='ดูรายการ'><i class='fas fa-search'></i></button>
	                  <button class='btn btn-sm btn-secondary' onclick='GoPostCodeEdit(this)' code='$row->Code' data-toggle='tooltip' data-placement='bottom' title='แก้ไขรายการ'><i class='fas fa-edit'></i></button>
	                  </td>
					</tr>";
			}
			}
            }
            $Table .= '</tbody></table>';
        // Encode To Json
				$arrayTable = array('Table' => $Table);
				$Jsonencode = json_encode($arrayTable);
				echo $Jsonencode;
	}

  public function TableToday()
  {
    $Today = date('Y-m-d');
    $DataCode = DB::table('main_table')
				->select(DB::raw('*, LEFT(Name, 10) AS Nameshot'))
				->where('Status', 'OUT')->where('date', $Today)->limit(10)->get();
    // Table
    $Table = '
            <table class="table table-sm animated bounceIn" id="TableOnlineDatatable">
              <thead>
                <tr align="center">
                  <th scope="col">No.</th>
                  <th scope="col">Code</th>
                  <th scope="col">Name (CheckOut)</th>
                  <th scope="col">Action</th>
                </tr>
              </thead><tbody style="font-size: 14px;">';

            $i = 0;
            foreach ($DataCode as $key => $row) {
            $i++;
			$Showkey_onuse_count_td = DB::table('detail_table')->where('main_id', $row->ID)->where('itemcode', 'P14')->limit(5)->count();
			$Showkey_onuse_td = DB::table('detail_table')->where('main_id', $row->ID)->where('itemcode', 'P14')->limit(5)->get();
			$Class_show = DB::table('fake_table')->where('main_id', $row->ID)->where('Fake_itemtype', 'C')->limit(1)->get();
			if (isset($Class_show[0]->Fake_itemname)) {
				$Class = "( <i class='fas fa-walking'></i>".$Class_show[0]->Fake_itemname." )";
			}else {
				$Class = "";
			}
			$ModifyTimeTodayy = date("H:i" , strtotime($row->Guset_out));
			$GuestHotel = DB::table('member')->where('code', $row->Code)->get();
			if ($Showkey_onuse_count_td == '1') {
			if ($GuestHotel[0]->type == 'Hotel') {
				$Table .= "
	                <tr align='center'>
	                  <td>$i</td>
	                  <td>$row->Code</td>
	                  <td align='left'><span style='cursor: pointer;' data-toggle='tooltip' data-placement='top' title='$row->Name'>$row->Nameshot... ($ModifyTimeTodayy)</span>  (<i class='fas fa-key'></i> ". $Showkey_onuse_td[0]->sum .") (<i class='fas fa-door-open'></i> ". $GuestHotel[0]->wifipassword .") $Class</td>
	                  <td>
	                  <button class='btn btn-sm btn-primary' onclick='ShowViewDataMain(this)' main_id='$row->ID' code='$row->Code' name='$row->Name' Guset_in='$row->Guset_in' data-toggle='tooltip' data-placement='bottom' title='ดูรายการ'><i class='fas fa-search'></i></button>
	                  </td>
					</tr>";								
			}else{
			$Table .= "
	                <tr align='center'>
	                  <td>$i</td>
	                  <td>$row->Code</td>
	                  <td align='left'><span style='cursor: pointer;' data-toggle='tooltip' data-placement='top' title='$row->Name'>$row->Nameshot... ($ModifyTimeTodayy)</span>  (<i class='fas fa-key'></i> ". $Showkey_onuse_td[0]->sum .") $Class</td>
	                  <td>
	                  <button class='btn btn-sm btn-primary' onclick='ShowViewDataMain(this)' main_id='$row->ID' code='$row->Code' name='$row->Name' Guset_in='$row->Guset_in' data-toggle='tooltip' data-placement='bottom' title='ดูรายการ'><i class='fas fa-search'></i></button>
	                  </td>
					</tr>";
			}
			}elseif ($Showkey_onuse_count_td == '2') {
			if ($GuestHotel[0]->type == 'Hotel') {
			$Table .= "
	                <tr align='center'>
	                  <td>$i</td>
	                  <td>$row->Code</td>
	                  <td align='left'><span style='cursor: pointer;' data-toggle='tooltip' data-placement='top' title='$row->Name'>$row->Nameshot... ($ModifyTimeTodayy)</span>  (<i class='fas fa-key'></i> ". $Showkey_onuse_td[0]->sum .") (<i class='fas fa-key'></i> ". $Showkey_onuse_td[1]->sum .") (<i class='fas fa-door-open'></i> ". $GuestHotel[0]->wifipassword .") $Class</td>
	                  <td>
	                  <button class='btn btn-sm btn-primary' onclick='ShowViewDataMain(this)' main_id='$row->ID' code='$row->Code' name='$row->Name' Guset_in='$row->Guset_in' data-toggle='tooltip' data-placement='bottom' title='ดูรายการ'><i class='fas fa-search'></i></button>
	                  </td>
					</tr>";								
			}else{
			$Table .= "
	                <tr align='center'>
	                  <td>$i</td>
	                  <td>$row->Code</td>
	                  <td align='left'><span style='cursor: pointer;' data-toggle='tooltip' data-placement='top' title='$row->Name'>$row->Nameshot... ($ModifyTimeTodayy)</span>  (<i class='fas fa-key'></i> ". $Showkey_onuse_td[0]->sum .") (<i class='fas fa-key'></i> ". $Showkey_onuse_td[1]->sum .") $Class</td>
	                  <td>
	                  <button class='btn btn-sm btn-primary' onclick='ShowViewDataMain(this)' main_id='$row->ID' code='$row->Code' name='$row->Name' Guset_in='$row->Guset_in' data-toggle='tooltip' data-placement='bottom' title='ดูรายการ'><i class='fas fa-search'></i></button>
	                  </td>
					</tr>";
			}
			}elseif ($Showkey_onuse_count_td == '3') {
			if ($GuestHotel[0]->type == 'Hotel') {
			$Table .= "
	                <tr align='center'>
	                  <td>$i</td>
	                  <td>$row->Code</td>
	                  <td align='left'><span style='cursor: pointer;' data-toggle='tooltip' data-placement='top' title='$row->Name'>$row->Nameshot... ($ModifyTimeTodayy)</span>  (<i class='fas fa-key'></i> ". $Showkey_onuse_td[0]->sum .") (<i class='fas fa-key'></i> ". $Showkey_onuse_td[1]->sum .") (<i class='fas fa-key'></i> ". $Showkey_onuse_td[2]->sum .") (<i class='fas fa-door-open'></i> ". $GuestHotel[0]->wifipassword .") $Class</td>
	                  <td>
	                  <button class='btn btn-sm btn-primary' onclick='ShowViewDataMain(this)' main_id='$row->ID' code='$row->Code' name='$row->Name' Guset_in='$row->Guset_in' data-toggle='tooltip' data-placement='bottom' title='ดูรายการ'><i class='fas fa-search'></i></button>
	                  </td>
					</tr>";								
			}else{
			$Table .= "
	                <tr align='center'>
	                  <td>$i</td>
	                  <td>$row->Code</td>
	                  <td align='left'><span style='cursor: pointer;' data-toggle='tooltip' data-placement='top' title='$row->Name'>$row->Nameshot... ($ModifyTimeTodayy)</span>  (<i class='fas fa-key'></i> ". $Showkey_onuse_td[0]->sum .") (<i class='fas fa-key'></i> ". $Showkey_onuse_td[1]->sum .") (<i class='fas fa-key'></i> ". $Showkey_onuse_td[2]->sum .") $Class</td>
	                  <td>
	                  <button class='btn btn-sm btn-primary' onclick='ShowViewDataMain(this)' main_id='$row->ID' code='$row->Code' name='$row->Name' Guset_in='$row->Guset_in' data-toggle='tooltip' data-placement='bottom' title='ดูรายการ'><i class='fas fa-search'></i></button>
	                  </td>
					</tr>";
			}
			}elseif ($Showkey_onuse_count_td == '4') {
			if ($GuestHotel[0]->type == 'Hotel') {
			$Table .= "
	                <tr align='center'>
	                  <td>$i</td>
	                  <td>$row->Code</td>
	                  <td align='left'><span style='cursor: pointer;' data-toggle='tooltip' data-placement='top' title='$row->Name'>$row->Nameshot... ($ModifyTimeTodayy)</span>  (<i class='fas fa-key'></i> ". $Showkey_onuse_td[0]->sum .") (<i class='fas fa-key'></i> ". $Showkey_onuse_td[1]->sum .") (<i class='fas fa-key'></i> ". $Showkey_onuse_td[2]->sum .") (<i class='fas fa-key'></i> ". $Showkey_onuse_td[3]->sum .") (<i class='fas fa-door-open'></i> ". $GuestHotel[0]->wifipassword .") $Class</td>
	                  <td>
	                  <button class='btn btn-sm btn-primary' onclick='ShowViewDataMain(this)' main_id='$row->ID' code='$row->Code' name='$row->Name' Guset_in='$row->Guset_in' data-toggle='tooltip' data-placement='bottom' title='ดูรายการ'><i class='fas fa-search'></i></button>
	                  </td>
					</tr>";								
			}else{
			$Table .= "
	                <tr align='center'>
	                  <td>$i</td>
	                  <td>$row->Code</td>
	                  <td align='left'><span style='cursor: pointer;' data-toggle='tooltip' data-placement='top' title='$row->Name'>$row->Nameshot... ($ModifyTimeTodayy)</span>  (<i class='fas fa-key'></i> ". $Showkey_onuse_td[0]->sum .") (<i class='fas fa-key'></i> ". $Showkey_onuse_td[1]->sum .") (<i class='fas fa-key'></i> ". $Showkey_onuse_td[2]->sum .") (<i class='fas fa-key'></i> ". $Showkey_onuse_td[3]->sum .") $Class</td>
	                  <td>
	                  <button class='btn btn-sm btn-primary' onclick='ShowViewDataMain(this)' main_id='$row->ID' code='$row->Code' name='$row->Name' Guset_in='$row->Guset_in' data-toggle='tooltip' data-placement='bottom' title='ดูรายการ'><i class='fas fa-search'></i></button>
	                  </td>
					</tr>";
			}
			}elseif ($Showkey_onuse_count_td == '5') {
			if ($GuestHotel[0]->type == 'Hotel') {
			$Table .= "
	                <tr align='center'>
	                  <td>$i</td>
	                  <td>$row->Code</td>
	                  <td align='left'><span style='cursor: pointer;' data-toggle='tooltip' data-placement='top' title='$row->Name'>$row->Nameshot... ($ModifyTimeTodayy)</span>  (<i class='fas fa-key'></i> ". $Showkey_onuse_td[0]->sum .") (<i class='fas fa-key'></i> ". $Showkey_onuse_td[1]->sum .") (<i class='fas fa-key'></i> ". $Showkey_onuse_td[2]->sum .") (<i class='fas fa-key'></i> ". $Showkey_onuse_td[3]->sum .") (<i class='fas fa-key'></i> ". $Showkey_onuse_td[4]->sum .") (<i class='fas fa-door-open'></i> ". $GuestHotel[0]->wifipassword .") $Class</td>
	                  <td>
	                  <button class='btn btn-sm btn-primary' onclick='ShowViewDataMain(this)' main_id='$row->ID' code='$row->Code' name='$row->Name' Guset_in='$row->Guset_in' data-toggle='tooltip' data-placement='bottom' title='ดูรายการ'><i class='fas fa-search'></i></button>
	                  </td>
					</tr>";								
			}else{
			$Table .= "
	                <tr align='center'>
	                  <td>$i</td>
	                  <td>$row->Code</td>
	                  <td align='left'><span style='cursor: pointer;' data-toggle='tooltip' data-placement='top' title='$row->Name'>$row->Nameshot... ($ModifyTimeTodayy)</span>  (<i class='fas fa-key'></i> ". $Showkey_onuse_td[0]->sum .") (<i class='fas fa-key'></i> ". $Showkey_onuse_td[1]->sum .") (<i class='fas fa-key'></i> ". $Showkey_onuse_td[2]->sum .") (<i class='fas fa-key'></i> ". $Showkey_onuse_td[3]->sum .") (<i class='fas fa-key'></i> ". $Showkey_onuse_td[4]->sum .") $Class</td>
	                  <td>
	                  <button class='btn btn-sm btn-primary' onclick='ShowViewDataMain(this)' main_id='$row->ID' code='$row->Code' name='$row->Name' Guset_in='$row->Guset_in' data-toggle='tooltip' data-placement='bottom' title='ดูรายการ'><i class='fas fa-search'></i></button>
	                  </td>
					</tr>";
			}
			}else{
			$Table .= "
	                <tr align='center'>
	                  <td>$i</td>
	                  <td>$row->Code</td>
	                  <td align='left'><span style='cursor: pointer;' data-toggle='tooltip' data-placement='top' title='$row->Name'>$row->Nameshot... ($ModifyTimeTodayy)</span> $Class</td>
	                  <td>
	                  <button class='btn btn-sm btn-primary' onclick='ShowViewDataMain(this)' main_id='$row->ID' code='$row->Code' name='$row->Name' Guset_in='$row->Guset_in' data-toggle='tooltip' data-placement='bottom' title='ดูรายการ'><i class='fas fa-search'></i></button>
	                  </td>
	                </tr>";
			}
            }
            $Table .= '</tbody></table>';
        // Encode To Json
    $arrayTable = array('Table' => $Table);
    $Jsonencode = json_encode($arrayTable);
    echo $Jsonencode;
  }

	public function ShowViewData()
	{
		$Code = Input::post('Code');
		$Name = Input::post('Name');
		$Guset_in = Input::post('Guset_in');
		$Main_id  = Input::post('Main_id');
		$ReGuset_in = date("d-m-Y H:i:s", strtotime($Guset_in));
    	$DataCode = DB::table('fake_table')->where('Fake_code', $Code)->where('main_id', $Main_id)->get();
    	$SumPrice = DB::table('fake_table')->where('Fake_code', $Code)->where('main_id', $Main_id)->sum('Fake_price');
    	$CounCheckNull = DB::table('fake_table')->where('Fake_code', $Code)->where('main_id', $Main_id)->count();
		//Table
		$Data = "
		<div class='row'>
		<div class='col-md-12'>
		<div align='center' class='animated fadeInDown'>
		<h5><b>ชื่อ:</b> $Name <br><b>เวลา:</b> $ReGuset_in </h5>
		</div>
		</div>
		</div>
		<table class='table table-sm table-hover animated fadeInUp'>
            <thead>
            <tr align='center' class='bg-primary'>
	    		  <th>ลำดับที่</th>
	    		  <th>รหัสโค้ด</th>
	    		  <th>รายการ</th>
	    		  <th>จำนวน</th>
	    		  <th>ราคา</th>
            </tr>
    </thead><tbody style='font-size: 12px;'>";
    // Have Data
    if ($CounCheckNull > 0) {
    $i =0;
		foreach ($DataCode as $key => $DataDisplay) {
		$i++;
		$Data .= "
		<tr align='center'>
		<td>$i</td>
		<td>$DataDisplay->Fake_itemcode</td>
		<td>$DataDisplay->Fake_itemname</td>";
		if ($DataDisplay->Fake_itemcodetype == 'F') {
		$Data .= "<td>หมายเลข $DataDisplay->Fake_sum#</td>";
		}else{
		$Data .= "<td>$DataDisplay->Fake_sum</td>";
		}
		$Data .= "<td>".number_format($DataDisplay->Fake_price)."</td>
		</tr>";
		}
    }else{
    	$Data .= "
    	<tr align='center'>
    	<td colspan='6'>Null</td>
    	</tr>";
    }
    	//  Table Data
    	$Data .= "
    	<tr class='bg-primary'>
    	<td colspan='4' align='right'><b>ราคารวม:</b></td>
    	<td align='center'>".number_format($SumPrice) ." <b>฿</b></td>
    	</tr>";
		$Data .= '</tbody></table>';
		// Encode To Json
		$arrayTable = array('Table' => $Data);
		$Jsonencode = json_encode($arrayTable);
		echo $Jsonencode;
	}

  public function ShowViewDataMain()
  {
    $Code = Input::post('Code');
    $Name = Input::post('Name');
    $Guset_in = Input::post('Guset_in');
    $Main_id  = Input::post('Main_id');
    $ReGuset_in = date("d-m-Y H:i:s", strtotime($Guset_in));
    $DataCode = DB::table('detail_table')->where('code', $Code)->where('main_id', $Main_id)->get();
    $SumPrice = DB::table('detail_table')->where('code', $Code)->where('main_id', $Main_id)->sum('price');
    $CounCheckNull = DB::table('detail_table')->where('code', $Code)->where('main_id', $Main_id)->count();
    //Table
    $Data = "
    <div class='row'>
    <div class='col-md-12'>
    <div align='center' class='animated fadeInDown'>
    <h5><b>ชื่อ:</b> $Name <br><b>เวลา:</b> $ReGuset_in </h5>
    </div>
    </div>
    </div>
    <table class='table table-sm table-hover animated fadeInUp'>
            <thead>
            <tr align='center' class='bg-primary'>
            <th>ลำดับที่</th>
            <th>รหัสโค้ด</th>
            <th>รายการ</th>
            <th>จำนวน</th>
            <th>ราคา</th>
            </tr>
    </thead><tbody style='font-size: 12px;'>";
    // Have Data
    if ($CounCheckNull > 0) {
    $i =0;
    foreach ($DataCode as $key => $DataDisplay) {
    $i++;
    $Data .= "
    <tr align='center'>
    <td>$i</td>
    <td>$DataDisplay->itemcode</td>
    <td>$DataDisplay->itemname</td>";
		if ($DataDisplay->itemcodetype == 'F') {
			$Data .= "<td>หมายเลข $DataDisplay->sum#</td>";
		}else{
			$Data .= "<td>$DataDisplay->sum</td>";
		}
    $Data .= "<td>".number_format($DataDisplay->price)."</td>
    </tr>";
    }
    }else{
    $Data .= "
    <tr align='center'>
    <td colspan='6'>Null</td>
    </tr>";
    }
    //  Table Data
    $Data .= "
    <tr class='bg-primary'>
    <td colspan='4' align='right'><b>ราคารวม:</b></td>
    <td align='center'>".number_format($SumPrice) ." <b>฿</b></td>
    </tr>";
    $Data .= '</tbody></table>';
    // Encode To Json
    $arrayTable = array('Table' => $Data);
    $Jsonencode = json_encode($arrayTable);
    echo $Jsonencode;
  }

}
