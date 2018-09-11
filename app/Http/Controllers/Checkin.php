<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB as DB;
use Illuminate\Routing\Controller as BaseController;

class Checkin extends Controller
{
    public function CheckInPage()
    {
    	return view('CheckIn');
    }

    public function CheckInProcessor()
    {
        $Code = Input::post('inputcode');
        $CheckNum = DB::table('member')->where('code', $Code)->count();
        $CheckStatus = DB::table('member')->where('code', $Code)->where('status', 'Active')->count();
        $Data = DB::table('member')->where('code', $Code)->get();
        $Item = DB::table('item')->get();

        return view('CheckIn',[
            'Code'=>$Code,
            'CheckNum'=>$CheckNum,
            'CheckStatus'=>$CheckStatus,
            'Data'=>$Data,
            'Item'=>$Item]);
    }     

    public function Namesearching()
    {
    	$name = Input::post('name');
    	$status = Input::post('status');
    	if ($status=='all') {
    	$users_data = DB::table('member')
    					->select('*')
    					->where('name', 'like', '%'.$name.'%')
    					->orWhere('code', 'like', '%'.$name.'%')
    					->limit(100)
    					->get();
    	}else{
    	$users_data = DB::table('member')
    					->select('*')
    					->where('status', 'Active')
    					->where('name', 'like', '%'.$name.'%')
    					->orWhere('code', 'like', '%'.$name.'%')
    					->where('status', 'Active')
    					->limit(100)
    					->get();
    	}
    	// Table
    	$table = '
    	<br>
        <div class="row">
        <div class="col-md-12">
		<table class="table table-sm">
		  <thead>
		    <tr align="center" class="bg-primary">
		      <th scope="col">Code</th>
		      <th scope="col">History</th>
		      <th scope="col">ชื่อ-สนามสกุล</th>
		      <th scope="col">วันที่สิ้นสุดใช้งาน</th>
		      <th scope="col">ประเภท</th>
		      <th scope="col">สถานะ</th>
		    </tr>
		  </thead>
		  <tbody>';
		  foreach ($users_data as $key => $data) {
		// Change value
		if ($data->status == 'Active') {
			$restatus = 'ใช้งาน';
			$recode = "<a href='#'><span onclick='posttocheckin(this);' class='badge badge-pill badge-primary' code='$data->code'>$data->code</span></a>";
		}else{
			$restatus = 'หมดอายุ';
			$recode = "<a href='#'><span class='badge badge-pill badge-danger'>$data->code</span></a>";
		}
		// Table
		$table .= "  	
		    <tr align='center'>
		      <td>$recode</td>
		      <td><a href='#'><span class='badge badge-pill badge-primary'>ดูประวัติ</span></a></td>
		      <td>$data->name</td>
		      <td>".date('d-m-Y', strtotime($data->expire))."</td>
		      <td>$data->type</td>
		      <td>$restatus</td>
		    </tr>";
		    }
		$table .= '</tbody></table></div></div>';
		// Show Json
    	$array = array('Table' => $table);
    	$json = json_encode($array);
    	echo $json;
    }

    public function CheckInOnline()
    {
        date_default_timezone_set("Asia/Bangkok");
        $today = now(); 
        $date = date("Y-m-d");
    	$Code = Input::post('Code');
    	$Data = DB::table('member')->where('code', $Code)->get();
    	foreach ($Data as $key => $row) {
	        // Insert Data Online
	    $id = DB::table('main_table')->insertGetId([
	    	'Code' => $row->code, 
	    	'Name' => $row->name,
	    	'Guset_in' => $today,
	    	'Status' => 'IN',
            'date' => $date]); 
        DB::table('fake_table')
            ->where('Fake_code', $Code)
            ->update(['main_id' => $id]);
    	}
    }

    public function Insert_type_L()
    {
        date_default_timezone_set("Asia/Bangkok");
        $today = now(); 
        $code = Input::post('Code');
        $itemcode = Input::post('Item_code');
        $itemtype = Input::post('Item_type');
        $itemname = Input::post('Item_name');
        $itemprice= Input::post('Item_price');
        $itemcodetype = Input::post('Item_codetype');
        // Insert Data
        DB::table('fake_table')->insert([
    	'Fake_code' => $code, 
    	'Fake_datetime' => $today,
    	'Fake_itemcode' => $itemcode,
        'Fake_itemcodetype' => $itemcodetype,
    	'Fake_itemtype' => $itemtype,
    	'Fake_itemname' => $itemname,
    	'Fake_price'    => $itemprice,
    	'Fake_sum'      => '1',
    	]);   
    }

    public function FunctionName()
    {
        date_default_timezone_set("Asia/Bangkok");
        $today = now();
    }

    public function TableDisplay()
    {
    	$Code = Input::post('Code');
    	$DataCode = DB::table('fake_table')->where('Fake_code', $Code)->get();
    	$SumPrice = DB::table('fake_table')->where('Fake_code','=', $Code)->sum('Fake_price');
    	$CounCheckNull = DB::table('fake_table')->where('Fake_code', $Code)->count();
        $CounMainOnline = DB::table('main_table')->where('Code', $Code)->where('Status', 'IN')->count();
    	//  Table Data
    	$Data = '
    	<table class="table table-sm table-hover animated flipInX">
    		<thead>
    		  <tr align="center" class="bg-primary">
    		  <th>ลำดับที่</th>
    		  <th>รหัสโค้ด</th>
    		  <th>รายการ</th>
    		  <th>ราคา</th>
    		  <th>จำนวน</th>
    		  <th>ตัวช่วย</th>
    		  </tr>
    		</thead><tbody>';
    	// Have Data
    	if ($CounCheckNull > 0) {
    	$i = 0;
    	foreach ($DataCode as $key => $DataDisplay) {
    	$i++;
        //Select Item type code
        if ($DataDisplay->Fake_itemcodetype == 'P') {
            //Piece
            $Itemtypcode = 'ผืน';
        }elseif ($DataDisplay->Fake_itemcodetype == 'C') {
            //Bottle
            $Itemtypcode = 'ขวด';
        }elseif ($DataDisplay->Fake_itemcodetype == 'T') {
            //Time
            $Itemtypcode = 'ชั่วโมง';
        }else{
            // Null
            $Itemtypcode = '';
        }

    	$Data .= "
    	<tr align='center'>
    	<td>$i</td>
    	<td>$DataDisplay->Fake_itemcode</td>
    	<td>$DataDisplay->Fake_itemname</td>
    	<td>".number_format($DataDisplay->Fake_price)." ฿</td>   	
    	<td>$DataDisplay->Fake_sum $Itemtypcode</td> 
    	<td>";
        if ($CounMainOnline == '0') {
        $Data .= "
        <button class='btn btn-sm btn-primary' onclick='Edit_Number(this);' fake_table_id='$DataDisplay->id'><i class='fas fa-dollar-sign'></i></button>
        <button class='btn btn-sm btn-danger' onclick='Delete_item(this);' fake_table_id='$DataDisplay->id'><i class='fas fa-trash'></i></button>";
        }else{
        $Data .= "<span class='badge badge-primary'>ลูกค้ากำลังใช้งาน</span>";    
        }
        $Data .= "</td>
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
    	<td colspan='5' align='right'><b>ราคารวม:</b></td>
    	<td align='center'>$SumPrice  <b>฿</b></td>
    	</tr>";
    	$Data .= '</tbody></table>';
    	// Have Data
    	if ($CounCheckNull > 0) {  
        if ($CounMainOnline == '0') {	
    	$Data .= '
    	<div align="center">
    	<button class="btn btn-success animated pulse" data-toggle="tooltip" data-placement="bottom" title="ยืนยันเข้าใช้งานวันนี้" onclick="CheckInOnline(this);">เข้าใช้งาน</button>
    	</div>';
        }else{
        $Data .= '
        <div align="center">
        <span class="badge badge-danger">ลูกค้า กำลังใช้งาน อยู่</span>
        </div>';    
        }
    	}else{
    	$Data .= '
    	<div align="center">
    	<button class="btn btn-success animated pulse" disabled data-toggle="tooltip" data-placement="bottom" title="กรุณาเลือกรายการก่อน">เข้าใช้งาน</button>
    	</div>';    		
    	}
		// Show Json
    	$array = array('Table' => $Data);
    	$json = json_encode($array);
    	echo $json;
    }

    public function TablePane()
    {
        $Code = Input::post('Code');
        $Item = DB::table('item')->get();
        $CounMainOnline = DB::table('main_table')->where('Code', $Code)->where('Status', 'IN')->count();
        if ($CounMainOnline == '0') {
        //Nav tab
        $Navtab = '
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="true">ทั่วไป</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="cose-tab" data-toggle="tab" href="#cose" role="tab" aria-controls="cose" aria-selected="false">ซื้อคอส</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Contact</a>
            </li>
        </ul>';
        //Tab pane
        $Navtab .= '
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                <table class="table table-bordered table-sm table-hover">
                    <thead>
                    <tr align="center" class="bg-primary">
                        <th>ชื่อรายการ</th>
                        <th>จำนวน</th>
                        <th>ราคา</th>
                        <th>ตัวช่วย</th>
                    </tr>
                    </thead>
                    <tbody>';
                    foreach ($Item as $Item_Free) {
                    if ($Item_Free->item_type == "L") {
                        $Navtab .= "
                        <tr item_codetype='$Item_Free->item_code_type' item_code='$Item_Free->item_code' item_name='$Item_Free->item_name' item_price='$Item_Free->item_price' item_type='$Item_Free->item_type' item_setnumber='$Item_Free->item_setnumber' ondblclick='Item_To_Disktop(this)'>
                            <td><b>$Item_Free->item_name</b></td>
                            <td align='center'>$Item_Free->item_setnumber</td>
                            <td align='center'>".number_format($Item_Free->item_price)."</td>
                            <td align='center'><button item_codetype='$Item_Free->item_code_type' item_code='$Item_Free->item_code' item_name='$Item_Free->item_name' item_price='$Item_Free->item_price' item_type='$Item_Free->item_type' item_setnumber='$Item_Free->item_setnumber' onclick='Item_To_Disktop(this)' class='btn btn-sm btn-primary'><i class='far fa-check-square'></i></button></td>
                        </tr>";
                    }
                    }
        //Nav tab
        $Navtab .= '        
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="cose" role="tabpanel" aria-labelledby="cose-tab">
                <table class="table table-bordered table-sm table-hover">
                    <thead>
                        <tr align="center" class="bg-primary">
                            <th>ชื่อรายการ</th>
                            <th>จำนวน</th>
                            <th>ราคา</th>
                            <th>ตัวช่วย</th>
                        </tr>
                    </thead>
                    <tbody>';
                    foreach ($Item as $Item_Free) {
                    if ($Item_Free->item_type == "C") {
                        $Navtab .= "
                        <tr item_codetype='$Item_Free->item_code_type' item_code='$Item_Free->item_code' item_name='$Item_Free->item_name' item_price='$Item_Free->item_price' item_type='$Item_Free->item_type' item_setnumber='$Item_Free->item_setnumber' ondblclick='Item_To_Disktop(this)'>
                            <td><b>$Item_Free->item_name</b></td>
                            <td align='center'>$Item_Free->item_setnumber</td>
                            <td align='center'>".number_format($Item_Free->item_price)."</td>
                            <td align='center'><button item_codetype='$Item_Free->item_code_type' item_code='$Item_Free->item_code' item_name='$Item_Free->item_name' item_price='$Item_Free->item_price' item_type='$Item_Free->item_type' item_setnumber='$Item_Free->item_setnumber' onclick='Item_To_Disktop(this)' class='btn btn-sm btn-primary'><i class='far fa-check-square'></i></button></td>
                        </tr>";
                    }
                    }    
        //Nav tab
        $Navtab .= '                         
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
        </div>';   
        }else{
        //Nav tab
        $Navtab = '
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="true">ทั่วไป</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="cose-tab" data-toggle="tab" href="#cose" role="tab" aria-controls="cose" aria-selected="false">ซื้อคอส</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Contact</a>
            </li>
        </ul>';
        //Tab pane
        $Navtab .= '
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                <table class="table table-bordered table-sm table-hover">
                    <thead>
                    <tr align="center" class="bg-primary">
                        <th>ชื่อรายการ</th>
                        <th>จำนวน</th>
                        <th>ราคา</th>
                        <th>ตัวช่วย</th>
                    </tr>
                    </thead>
                    <tbody>';
                    foreach ($Item as $Item_Free) {
                    if ($Item_Free->item_type == "L") {
                        $Navtab .= "
                        <tr item_codetype='$Item_Free->item_code_type' item_code='$Item_Free->item_code' item_name='$Item_Free->item_name' item_price='$Item_Free->item_price' item_type='$Item_Free->item_type'>
                            <td><b>$Item_Free->item_name</b></td>
                            <td align='center'>$Item_Free->item_setnumber</td>
                            <td align='center'>".number_format($Item_Free->item_price)."</td>
                            <td align='center'><span class='badge badge-primary'>ลูกค้ากำลังใช้งาน</span></td>
                        </tr>";
                    }
                    }
        //Nav tab
        $Navtab .= '        
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="cose" role="tabpanel" aria-labelledby="cose-tab">
                <table class="table table-bordered table-sm table-hover">
                    <thead>
                        <tr align="center" class="bg-primary">
                            <th>ชื่อรายการ</th>
                            <th>จำนวน</th>
                            <th>ราคา</th>
                            <th>ตัวช่วย</th>
                        </tr>
                    </thead>
                    <tbody>';
                    foreach ($Item as $Item_Free) {
                    if ($Item_Free->item_type == "C") {
                        $Navtab .= "
                        <tr item_codetype='$Item_Free->item_code_type' item_code='$Item_Free->item_code' item_name='$Item_Free->item_name' item_price='$Item_Free->item_price' item_type='$Item_Free->item_type'>
                            <td><b>$Item_Free->item_name</b></td>
                            <td align='center'>$Item_Free->item_setnumber</td>
                            <td align='center'>".number_format($Item_Free->item_price)."</td>
                            <td align='center'><span class='badge badge-primary'>ลูกค้ากำลังใช้งาน</span></td>
                        </tr>";
                    }
                    }    
        //Nav tab
        $Navtab .= '                         
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
        </div>';

        }

        // Show Json
        $array = array('Navtab' => $Navtab);
        $json = json_encode($array);
        echo $json;            
    }

    public function EditNumber()
    {
        $Fake_table_id = Input::post('Fake_table_id');
        $Fake_Table  = DB::table('fake_table')->where('id', $Fake_table_id)->get();
        foreach ($Fake_Table as $key => $GetItemFull) {
            $TableItem = DB::table('item')->where('item_code', $GetItemFull->Fake_itemcode)->get();
        }
        $From = "
        <div class='row'>
        <div class='col-md-6' align='center'>";
        foreach ($TableItem as $key => $row) {
            $From .= "<h5><b>รายการ:</b> $row->item_name</h5>";
        }
        $From .= "</div><div class='col-md-6' align='center'>";
        foreach ($TableItem as $key => $row) {
            $From .= "<h5><b>ราคา:</b> $row->item_price ฿</h5>";
        }
        $From .= "</div></div>";
        $From .= "
        <div class='row'>
        <div class='col-md-12' align='center'>
        <div class='col-sm-3'>";
        foreach ($Fake_Table as $key => $GetItemFull) {
           $From .= "<input type='number' class='form-control' autofocus id='newnumitem' value='$GetItemFull->Fake_sum'>";
        }  
        $From .= "</div>
        <hr>
        <button class='btn btn-primary' Fake_table_id='$Fake_table_id' onclick='Foronchangenum(this);'>ยืนยันเปลี่ยนจำนวน</button>
        </div>
        </div>";
        // Show Json
        $array = array('From' => $From);
        $json = json_encode($array);
        echo $json;        
    }

    public function Delete_item()
    {
        $Fake_table_id = Input::post('Fake_table_id');
        // Delete
        DB::table('fake_table')->where('id', $Fake_table_id)->delete();        
    }

    public function Foronchangenum()
    {
        $Fake_table_id = Input::post('Fake_table_id');
        $NewNum = Input::post('NewNum');
        $Fake_Table  = DB::table('fake_table')->where('id', $Fake_table_id)->get(); 
        foreach ($Fake_Table as $key => $GetItemFull) {
            $TableItem = DB::table('item')->where('item_code', $GetItemFull->Fake_itemcode)->get();
        }        
        foreach ($TableItem as $key => $row) {
                $item_price = $row->item_price;
                $totalprice = $NewNum * $item_price;
                // Update
                DB::table('fake_table')
                    ->where('id', $Fake_table_id)
                    ->update(['Fake_sum' => $NewNum, 'Fake_price' => $totalprice]);                
        }       
    }

    public function History()
    {
        print_r($_POST);
    }
}
