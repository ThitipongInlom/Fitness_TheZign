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
		$DataCode = DB::table('main_table')->where('Status', 'IN')->get();
		// Table
		$Table = '
            <table class="table table-sm animated bounceIn" id="TableOnlineDatatable">
              <thead>
                <tr align="center">
                  <th scope="col">ลำดับ</th>
                  <th scope="col">Code</th>
                  <th scope="col">ชื่อ</th>
                  <th scope="col">ตัวช่วย</th>
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
                  <button class='btn btn-sm btn-primary' data-toggle='modal' data-target='#Show_view_Data' onclick='ShowViewData(this)' main_id='$row->ID' code='$row->Code' name='$row->Name' Guset_in='$row->Guset_in' data-toggle='tooltip' data-placement='bottom' title='ดูรายการ'><i class='fas fa-search'></i></button>
                  <button class='btn btn-sm btn-secondary'><i class='fas fa-edit'></i></button>
                  </td>
                </tr>";
            }    
            $Table .= '</tbody></table>';
        // Encode To Json
		$arrayTable = array('Table' => $Table);
		$Jsonencode = json_encode($arrayTable);
		echo $Jsonencode;
	}	

	public function TableYesterday()
	{
		$date = date("m-d-Y");
		$date1 = str_replace('-', '/', $date);
		$Yesterday = date('Y-m-d',strtotime($date1 . "-1 days"));		
		$DataCode = DB::table('main_table')->where('Status', 'OUT')->where('date', $Yesterday)->limit(10)->get();
		// Table
		$Table = '
            <table class="table table-sm animated bounceIn" id="TableOnlineDatatable">
              <thead>
                <tr align="center">
                  <th scope="col">ลำดับ</th>
                  <th scope="col">Code</th>
                  <th scope="col">ชื่อ</th>
                  <th scope="col">ตัวช่วย</th>
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
                  <button class='btn btn-sm btn-primary' data-toggle='modal' data-target='#Show_view_Data' onclick='ShowViewDataMain(this)' main_id='$row->ID' code='$row->Code' name='$row->Name' Guset_in='$row->Guset_in'><i class='fas fa-search'></i></button>
                  </td>
                </tr>";
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
    $DataCode = DB::table('main_table')->where('Status', 'OUT')->where('date', $Today)->limit(10)->get();
    // Table
    $Table = '
            <table class="table table-sm animated bounceIn" id="TableOnlineDatatable">
              <thead>
                <tr align="center">
                  <th scope="col">ลำดับ</th>
                  <th scope="col">Code</th>
                  <th scope="col">ชื่อ</th>
                  <th scope="col">ตัวช่วย</th>
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
                  <button class='btn btn-sm btn-primary' data-toggle='modal' data-target='#Show_view_Data' onclick='ShowViewDataMain(this)' main_id='$row->ID' code='$row->Code' name='$row->Name' Guset_in='$row->Guset_in'><i class='fas fa-search'></i></button>
                  </td>
                </tr>";
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
       		</thead><tbody>";	
    	// Have Data
    	if ($CounCheckNull > 0) {
       	$i =0;
		foreach ($DataCode as $key => $DataDisplay) {
		$i++;
		$Data .= "
		<tr align='center'>
		<td>$i</td>
		<td>$DataDisplay->Fake_itemcode</td>
		<td>$DataDisplay->Fake_itemname</td>
		<td>$DataDisplay->Fake_sum</td>
		<td>".number_format($DataDisplay->Fake_price)."</td>
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
    	</tr>
    	";	  		
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
          </thead><tbody>"; 
      // Have Data
      if ($CounCheckNull > 0) {
        $i =0;
    foreach ($DataCode as $key => $DataDisplay) {
    $i++;
    $Data .= "
    <tr align='center'>
    <td>$i</td>
    <td>$DataDisplay->itemcode</td>
    <td>$DataDisplay->itemname</td>
    <td>$DataDisplay->sum</td>
    <td>".number_format($DataDisplay->price)."</td>
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
      </tr>
      ";        
    $Data .= '</tbody></table>';
    // Encode To Json
    $arrayTable = array('Table' => $Data);
    $Jsonencode = json_encode($arrayTable);
    echo $Jsonencode; 
  }
}
