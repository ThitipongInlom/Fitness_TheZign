<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB as DB;
use Illuminate\Routing\Controller as BaseController;

class Checkout extends Controller
{
    public function CheckOutPage()
    {
    	return view('CheckOut');
    }

    public function Tableonlineforlogout()
    {
		$DataCode = DB::table('main_table')->where('Status', 'IN')->get();
		// Table
		$Table = '
            <table class="table table-sm animated bounceIn" id="TableOnlineDatatable">
              <thead>
                <tr align="center">
                  <th scope="col">ลำดับ</th>
                  <th scope="col">Code</th>
                  <th scope="col">ชื่อ</th>
                  <th scope="col">เลือก</th>
                </tr>
              </thead><tbody>';

            $i = 0;
            foreach ($DataCode as $key => $row) {
            $i++;
            $Table .= "
                <tr align='center'>
                  <td>$i</td>
                  <td>$row->Code</td>
                  <td>$row->Name</td>
                  <td>
                  <button class='btn btn-sm btn-primary' id='listid_$row->ID' main_id='$row->ID' code='$row->Code' onclick='Showdatatologout(this);' data-toggle='tooltip' data-placement='bottom' title='ย้อนกลับหน้า เลือก รายการ'><i class='fas fa-check-circle'></i></button>
                  </td>
                </tr>";
            }
            $Table .= '</tbody></table>';
        // Encode To Json
		$arrayTable = array('Table' => $Table);
		$Jsonencode = json_encode($arrayTable);
		echo $Jsonencode;
    }

    public function Showdatatologout()
    {
		$Code = Input::post('Code');
		$Main_id = Input::post('Main_id');
    	$DataCode = DB::table('fake_table')->where('Fake_code', $Code)->get();
    	$SumPrice = DB::table('fake_table')->where('Fake_code','=', $Code)->sum('Fake_price');
    	$CounCheckNull = DB::table('fake_table')->where('Fake_code', $Code)->count();
    	//  Table Data
    	$Data = "
    	<div class='row'>
    	<div class='col-md-12'>
    	<div align='center' class='animated zoomIn'>
    	<h4><b>Code:</b>$Code</h4>
    	</div>
    	</div>
    	</div>
    	<table class='table table-sm table-hover animated flipInX'>
    		<thead>
    		  <tr align='center' class='bg-primary'>
    		  <th>ลำดับที่</th>
    		  <th>รหัสโค้ด</th>
    		  <th>รายการ</th>
    		  <th>จำนวน</th>
    		  <th>ราคา</th>
    		  <th>ตัวช่วย</th>
    		  </tr>
    		</thead><tbody>";
    	// Have Data
    	if ($CounCheckNull > 0) {
    	$i = 0;
    	foreach ($DataCode as $key => $DataDisplay) {
    	$i++;
    	$Data .= "
      <input type='hidden' id='pricehidden' value='$DataDisplay->Fake_price'>
      <input type='hidden' id='pricehiddenformat' value='".number_format($DataDisplay->Fake_price)."'>
    	<tr align='center'>
    	<td>$i</td>
    	<td>$DataDisplay->Fake_itemcode</td>
    	<td>$DataDisplay->Fake_itemname</td>
    	<td>$DataDisplay->Fake_sum</td>
    	<td>".number_format($DataDisplay->Fake_price)." ฿</td>
    	<td></td>
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
    	<tr align='center' class='bg-primary'>
    	<td colspan='4' align='right'><b>ราคารวม:</b></td>
    	<td align='center'>".number_format($SumPrice)." <b>฿</b></td>
    	<td><b>ตัวช่วย</b></td>
    	</tr>
    	";
    	$Data .= '</tbody></table>';
    	$Data .="
    	<div class='row'>
    	<div class='col-md-12'>
    	<div align='center'>
    	<button type='button' class='btn btn-primary' code='$Code' Main_id='$Main_id' onclick='Dologout(this);'>ยืนยันเช็คเอาท์</button>
    	</div>
    	</div>
    	</div>";
		// Show Json
    	$array = array('Table' => $Data);
    	$json = json_encode($array);
    	echo $json;
    }

    public function Dologout()
    {
      date_default_timezone_set("Asia/Bangkok");
      $today = now();
    	$Main_id = Input::post('Main_id');
    	$Code    = Input::post('Code');
    	$DataCode = DB::table('fake_table')->where('main_id', $Main_id)->where('Fake_code', $Code)->get();
    	// Insert
    	foreach ($DataCode as $key => $row) {
			DB::table('detail_table')->insert([
			    'main_id' => $Main_id,
			    'code' => $Code,
			    'date_time' => $row->Fake_datetime,
			    'itemcode'  => $row->Fake_itemcode,
			    'itemtype'  => $row->Fake_itemtype,
			    'itemname'  => $row->Fake_itemname,
			    'price'     => $row->Fake_price,
			    'sum'       => $row->Fake_sum,
          'status'    => $row->Fake_status,
          'comment'   => $row->Fake_comment,
			]);
    	}
    	// Update
        DB::table('main_table')
            ->where('Code', $Code)
            ->update(['Guset_out' => $today,'Status' => 'OUT']);
    	// Delete Fake_table
    	DB::table('fake_table')->where('main_id', $Main_id)->where('Fake_code', $Code)->delete();
      // Delete Onuse Package
      DB::table('package_onuse')->where('code', $Code)->delete();
    }
}
