<?php

namespace App\Http\Controllers;

use App;
use Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB as DB;
use Illuminate\Http\Request;

class Report extends Controller
{

  public function Report()
	{
		return view('Report');
	}

  public function Report_tab_1(Request $request)
  {
    $range_date = explode(" - ", $request->post('range_date'));
    $reformat_start = date('Y-m-d', strtotime(str_replace('/', '-', $range_date[0])));
    $reformat_end   = date('Y-m-d', strtotime(str_replace('/', '-', $range_date[1])));
    // Query DATA
    $DATA = DB::table('main_table')
             ->join('detail_table', 'main_table.ID', '=', 'detail_table.main_id')
             ->join('member', 'main_table.Code', '=', 'member.code')
             ->groupBy('main_table.Guset_in')
             ->orderBy('main_table.Guset_in', 'ASC')
             ->where('main_table.Status', '=', 'OUT')
             ->whereBetween('date', [$reformat_start, $reformat_end])
             ->get();
    // Total L3 ผ้าผืนใหญ่
    $Total_L3 = DB::table('main_table')
             ->select('*', DB::raw('SUM(detail_table.sum) as total_sum_l3'))
             ->join('detail_table', 'main_table.ID', '=', 'detail_table.main_id')
             ->where('detail_table.itemcode', '=', 'L3')
             ->whereBetween('date', [$reformat_start, $reformat_end])
             ->get();
             foreach ($Total_L3 as $key => $row) {
               if ($row->total_sum_l3 == null) {
                 $Sum_L3 = '0';
               }else {
                 $Sum_L3 = $row->total_sum_l3;
               }
             }
    // Total L1 ผ้าผืนเล็ก
    $Total_L1 = DB::table('main_table')
             ->select('*', DB::raw('SUM(detail_table.sum) as total_sum_l1'))
             ->join('detail_table', 'main_table.ID', '=', 'detail_table.main_id')
             ->where('detail_table.itemcode', '=', 'L1')
             ->whereBetween('date', [$reformat_start, $reformat_end])
             ->get();
             foreach ($Total_L1 as $key => $row) {
               if ($row->total_sum_l1 == null) {
                $Sum_L1 = '0';
               }else{
                $Sum_L1 = $row->total_sum_l1;
               }
             }
    // Taotal L2 เสื้อคลุม
    $Total_L2 = DB::table('main_table')
             ->select('*', DB::raw('SUM(detail_table.sum) as total_sum_l2'))
             ->join('detail_table', 'main_table.ID', '=', 'detail_table.main_id')
             ->where('detail_table.itemcode', '=', 'L2')
             ->whereBetween('date', [$reformat_start, $reformat_end])
             ->get();
             foreach ($Total_L2 as $key => $row) {
               if ($row->total_sum_l2 == null) {
                 $Sum_L2 = '0';
               }else{
                 $Sum_L2 = $row->total_sum_l2;
               }
             }
    $Table  = "<div align='center'><h4><b>รายงานการใช้บริการสมาชิกตามช่วงเวลา</b></h4></div>";
    $Table .= "<div align='center'><b>ระหว่างวันที่ ".$range_date[0]." ถึงวันที่ ".$range_date[1]."</b></div>";
    $Table .= "<table class='table table-sm mt-2'>";
    $Table .= "<thead align='center'><tr><th>ลำดับ</th><th>รหัสสมาชิก</th><th>ชื่อนามสกุล</th><th>กุญแจ</th><th>วันที่</th><th>เวลาเข้า</th><th>เวลาออก</th><th>รวมเป็นเวลา</th></tr></thead>";
    $Table .= "<tbody>";
    $i = 1;
    $member_count = 0;
    $k_bank = 0;
    $hotel_count = 0;
    $gusetpass = 0;
    $day1 = 0;
    foreach ($DATA as $key => $row) {
      $Sumdate = date("H:i:s",(strtotime($row->Guset_out) - strtotime($row->Guset_in)));
      $getkey = DB::table('detail_table')->where('main_id', '=', "$row->main_id")->where('itemcode', '=', "P14")->limit(1)->get();
      foreach ($getkey as $key => $rowkey) {
          if ($rowkey->sum != '') {
            $keysum = $rowkey->sum;
          }else{
            $keysum = 'Null';
          }
      }
      if (empty($keysum)) {
        $keysum = '';
      }else{
        $keysum = $keysum;
      }
      $Table .= "<tr align='center'><td>$i</td><td>$row->Code</td><td align='left'>$row->Name</td><td>$keysum</td><td>".date('d/m/Y', strtotime($row->Guset_in))."</td><td>".date('H:i:s', strtotime($row->Guset_in))."</td><td>".date('H:i:s', strtotime($row->Guset_out))."</td><td>$Sumdate</td></tr>";
      $i++;
      if ($row->type == 'Hotel') {
        $hotel_count++;
      }elseif ($row->type == '1D'){
        $day1++;
      }elseif ($row->type == '1DM') {
        $gusetpass++;
      }elseif ($row->type == '1D-Kbank') {
        $k_bank++;
      }else{
        $member_count++;
      }
    }
    $re_i = $i - 1 ;
    $Table .= "</tbody>";
    $Table .= "</table>";
    $Table .= "<hr>";
    $Table .= "<div class='container'><div class='row'><div class='col-md-12'>";
    $Table .= "<table class='table table-bordered table-sm mt-2'>";
    $Table .= "<thead align='center'><tr><th>จำนวน(คน)</th><th>Member</th><th>1Day</th><th>Hotel</th><th>Guest Pass</th><th>K-bank</th><th>ผืนใหญ่</th><th>ผืนเล็ก</th><th>เสื้อคลุม</th></tr></thead>";
    $Table .= "<tbody><tr align='center'><td>$re_i</td><td>$member_count</td><td>$day1</td><td>$hotel_count</td><td>$gusetpass</td><td>$k_bank</td><td>$Sum_L3</td><td>$Sum_L1</td><td>$Sum_L2</td></tr></tbody>";
    $Table .= "</table>";
    $Table .= "</div></div></div>";


    return response()
            ->json(['Table' => $Table]);
    }

    public function Report_tab_2(Request $request)
    {
      $range_date = explode(" - ", $request->post('range_date'));
      $reformat_start = date('Y-m-d', strtotime(str_replace('/', '-', $range_date[0])));
      $reformat_end   = date('Y-m-d', strtotime(str_replace('/', '-', $range_date[1])));
      $select_teb = $request->post('select');
      if ($select_teb == '1') {
        // Query DATA
        $DATA = DB::table('main_table')
                ->join('detail_table', 'main_table.ID', '=', 'detail_table.main_id')
                ->join('member', 'main_table.Code', '=', 'member.code')
                ->groupBy('main_table.Guset_in')
                ->orderBy('main_table.Guset_in', 'ASC')
                ->where('detail_table.itemtype', 'like', 'C')
                ->where('main_table.Status', '=', 'OUT')
                ->whereBetween('date', [$reformat_start, $reformat_end])
                ->get();
        $Table  = "<div align='center'><h4><b>รายงานการใช้บริการคลาส</b></h4></div>";
        $Table .= "<div align='center'><b>ระหว่างวันที่ ".$range_date[0]." ถึงวันที่ ".$range_date[1]."</b></div>";
        $Table .= "<table class='table table-sm mt-2'>";
        $Table .= "<thead align='center'><tr><th>ลำดับ</th><th>รหัสสมาชิก</th><th>ชื่อนามสกุล</th><th>วันที่</th><th>เวลาเข้า</th><th>เวลาออก</th><th>คลาสที่ใช้</th></tr></thead>";
        $Table .= "<tbody>";
        $i = 1;
        foreach ($DATA as $key => $row) {
          $Table .= "<tr align='center'><td>$i</td><td>$row->Code</td><td align='left'>$row->Name</td><td>".date('d/m/Y', strtotime($row->Guset_in))."</td><td>".date('H:i:s', strtotime($row->Guset_in))."</td><td>".date('H:i:s', strtotime($row->Guset_out))."</td><td>$row->itemname</td></tr>";
          $i++;
        }
        $Table .= "</tbody>";
        $Table .= "</table>";
      }elseif ($select_teb == '2') {
        // Query DATA
        $DATA = DB::table('trainner')
                ->join('item', 'trainner.class_id', '=', 'item.item_code')
                ->join('trainner_emp', 'trainner.tn_emp_id', '=', 'trainner_emp.tn_emp_id')
                ->whereBetween('train_date', [$reformat_start, $reformat_end])
                ->get();
        $Table  = "<div align='center'><h4><b>รายงานการใช้บริการคลาส</b></h4></div>";
        $Table .= "<div align='center'><b>ระหว่างวันที่ ".$range_date[0]." ถึงวันที่ ".$range_date[1]."</b></div>";
        $Table .= "<table class='table table-sm mt-2'>";
        $Table .= "<thead align='center'><tr><th>ลำดับ</th><th>วันที่</th><th>คลาสที่ใช้งาน</th><th>ชื่อ เทรนเนอร์</th><th>เวลาเริ่ม</th><th>เวลาสิ้นสุด</th><th>จำนวนคนที่ใช้งาน</th></tr></thead>";
        $Table .= "<tbody>";
        $i = 1;
        foreach ($DATA as $key => $row) {
          $train_start = date('Y-m-d H:i:s', strtotime($row->train_date.' '.$row->train_time_start));
          $train_end = date('Y-m-d H:i:s', strtotime($row->train_date.' '.$row->train_time_end));
          $DATAF = DB::table('main_table')
                ->join('detail_table', 'main_table.ID', '=', 'detail_table.main_id')
                ->where('detail_table.itemcode', $row->class_id)
                ->where('main_table.Status', '=', 'OUT')
                ->whereBetween('main_table.date', [$row->train_date, $row->train_date])
                ->count();
          $Table .= "<tr align='center'><td>$i</td><td>".date('d/m/Y', strtotime($row->train_date))."</td><td>$row->item_name</td><td>$row->fname $row->lname</td><td>$row->train_time_start</td><td>$row->train_time_end</td><td>$DATAF คน</td></tr>";
          $i++; 
        }
        $Table .= "</tbody>";
        $Table .= "</table>";
      }elseif ($select_teb == '3') {
         // Query DATA
        $DATA = DB::table('package_log')
                ->join('package_detail', 'package_log.main_package_id', '=', 'package_detail.package_id')
                ->join('member', 'package_log.code', '=', 'member.code')
                ->join('main_table', 'package_log.code', '=', 'main_table.code')
                ->groupBy('package_log.package_log_id')
                ->orderBy('package_log.package_log_id', 'ASC')
                ->where('package_log.status', '=', 'U')
                ->whereBetween('package_log.date', [$reformat_start, $reformat_end])
                ->get();
        $Table  = "<div align='center'><h4><b>รายงานการใช้บริการคลาส</b></h4></div>";
        $Table .= "<div align='center'><b>ระหว่างวันที่ ".$range_date[0]." ถึงวันที่ ".$range_date[1]."</b></div>";
        $Table .= "<table class='table table-sm mt-2'>";
        $Table .= "<thead align='center'><tr><th>ลำดับ</th><th>รหัสสมาชิก</th><th>ชื่อนามสกุล</th><th>วันที่</th><th>เวลาเข้า</th><th>เวลาออก</th><th>คลาสที่ใช้</th><th>ใช้งานทั้งหมด</th></tr></thead>";
        $Table .= "<tbody>";
        $i = 1;
        foreach ($DATA as $key => $row) {
          $Table .= "<tr align='center'><td>$i</td><td>$row->code</td><td align='left'>$row->Name</td><td>".date('d/m/Y', strtotime($row->Guset_in))."</td><td>".date('H:i:s', strtotime($row->Guset_in))."</td><td>".date('H:i:s', strtotime($row->Guset_out))."</td><td>$row->fake_itemname</td><td>$row->onuse ซ.ม</td></tr>";
          $i++;
        }
        $Table .= "</tbody>";
        $Table .= "</table>";
      }else{
        $Table = "<div align='center'><h5 style='color:red;'>กรุณาเลือก ประเภทในการ แสดง</h5></div>";
      }

      return response()
              ->json(['Table' => $Table]);
    }

    public function Report_tab_3(Request $request)
    {
      $range_date = explode(" - ", $request->post('range_date'));
      $reformat_start = date('Y-m-d', strtotime(str_replace('/', '-', $range_date[0])));
      $reformat_end   = date('Y-m-d', strtotime(str_replace('/', '-', $range_date[1])));
      $select_name = $request->post('select_name');
      $select_class = $request->post('select_class');
      // 0 เท่ากับ class
      if ($request->post('select_class') == '0') {
        // Query DATA
        $DATA = DB::table('trainner')
                ->join('item', 'trainner.class_id', '=', 'item.item_code')
                ->join('trainner_emp', 'trainner.tn_emp_id', '=', 'trainner_emp.tn_emp_id')
                ->where('trainner.tn_emp_id',  $select_name)
                ->whereBetween('train_date', [$reformat_start, $reformat_end])
                ->get();
        $Table  = "<div align='center'><h4><b>รายงานการใช้บริการคลาส</b></h4></div>";
        $Table .= "<div align='center'><b>ระหว่างวันที่ ".$range_date[0]." ถึงวันที่ ".$range_date[1]."</b></div>";
        $Table .= "<table class='table table-sm mt-2'>";
        $Table .= "<thead align='center'><tr><th>ลำดับ</th><th>วันที่</th><th>คลาสที่ใช้งาน</th><th>ชื่อ เทรนเนอร์</th><th>เวลาเริ่ม</th><th>เวลาสิ้นสุด</th><th>จำนวนคนที่ใช้งาน</th></tr></thead>";
        $Table .= "<tbody>";
        $i = 1;
        foreach ($DATA as $key => $row) {
        $train_start = date('Y-m-d H:i:s', strtotime($row->train_date.' '.$row->train_time_start));
        $train_end = date('Y-m-d H:i:s', strtotime($row->train_date.' '.$row->train_time_end));
        $DATAF = DB::table('main_table')
                ->join('detail_table', 'main_table.ID', '=', 'detail_table.main_id')
                ->where('detail_table.itemcode', $row->class_id)
                ->where('main_table.Status', '=', 'OUT')
                //->whereBetween('main_table.Guset_in', [$train_start, $train_end])
                ->whereBetween('main_table.date', [$row->train_date, $row->train_date])
                ->count();
        $Table .= "<tr align='center'><td>$i</td><td>".date('d/m/Y', strtotime($row->train_date))."</td><td>$row->item_name</td><td align='left'>$row->fname $row->lname</td><td>$row->train_time_start</td><td>$row->train_time_end</td><td>$DATAF คน</td></tr>";
        $i++;  
        }
        $Table .= "</tbody>";
        $Table .= "</table>";
      }else{
         // Query DATA
        $DATA = DB::table('package_log')
                ->join('package_detail', 'package_log.main_package_id', '=', 'package_detail.package_id')
                ->join('member', 'package_log.code', '=', 'member.code')
                ->join('main_table', 'package_log.code', '=', 'main_table.code')
                ->groupBy('package_log.package_log_id')
                ->orderBy('package_log.package_log_id', 'ASC')
                ->where('package_log.status', '=', 'U')
                ->where('package_log.trainner_emp_id',  $select_name)
                ->whereBetween('package_log.date', [$reformat_start, $reformat_end])
                ->get();
        $Table  = "<div align='center'><h4><b>รายงานการใช้บริการคลาส</b></h4></div>";
        $Table .= "<div align='center'><b>ระหว่างวันที่ ".$range_date[0]." ถึงวันที่ ".$range_date[1]."</b></div>";
        $Table .= "<table class='table table-sm mt-2'>";
        $Table .= "<thead align='center'><tr><th>ลำดับ</th><th>รหัสสมาชิก</th><th>ชื่อนามสกุล</th><th>วันที่</th><th>เวลาเข้า</th><th>เวลาออก</th><th>คลาสที่ใช้</th><th>ใช้งานทั้งหมด</th></tr></thead>";
        $Table .= "<tbody>";
        $i = 1;
        foreach ($DATA as $key => $row) {
        $Table .= "<tr align='center'><td>$i</td><td>$row->code</td><td align='left'>$row->Name</td><td>".date('d/m/Y', strtotime($row->Guset_in))."</td><td>".date('H:i:s', strtotime($row->Guset_in))."</td><td>".date('H:i:s', strtotime($row->Guset_out))."</td><td>$row->fake_itemname</td><td>$row->onuse ซ.ม</td></tr>";
        $i++;
        }
        $Table .= "</tbody>";
        $Table .= "</table>";
      }

      return response()
              ->json(['Table' => $Table]);
    }

    public function Report_tab_4(Request $request)
    {
      $range_date = explode(" - ", $request->post('range_date'));
      $reformat_start = date('Y-m-d', strtotime(str_replace('/', '-', $range_date[0])));
      $reformat_end   = date('Y-m-d', strtotime(str_replace('/', '-', $range_date[1])));
      $select_type = $request->post('select_type');
      // เงี่อนไข ถ้าลูกค้่า Active
      if ($select_type == 'Active') {
        $Data = DB::table('member')
                  ->where('status',  'Active')
                  ->whereBetween('start', [$reformat_start, $reformat_end])
                  ->get();
      }else{
        $Data = DB::table('member')
                  ->where('status',  'Expired')
                  ->whereBetween('expire', [$reformat_start, $reformat_end])
                  ->get();
      }
      $Table  = "<div align='center'><h4><b>รายงานเช็คยอดลูกค้า</b></h4></div>";
      $Table .= "<div align='center'><b>ระหว่างวันที่ ".$range_date[0]." ถึงวันที่ ".$range_date[1]."</b></div>";
      $Table .= "<table class='table table-sm mt-2'>";
      $Table .= "<thead align='center'><tr><th>ลำดับ</th><th>รหัสสมาชิก</th><th>รหัสผ่าน</th><th>ชื่อนามสกุล</th><th>วันที่สมัคร</th><th>วันที่หมดอายุ</th><th>ประภท</th><th>เบอร์โทร</th><th>สถานะ</th></thead>";
      $Table .= "<tbody>";
      $i = 1;
      foreach ($Data as $key => $row) {
        $Table .= "<tr align='center'><td>$i</td><td>$row->code</td><td>$row->wifipassword</td><td align='left'>$row->name</td><td>".date('d/m/Y', strtotime($row->start))."</td><td>".date('d/m/Y', strtotime($row->expire))."</td><td>$row->type</td><td>$row->phone</td><td>$row->status</td></tr>";
        $i++;
      }
      $Table .= "</tbody>";
      $Table .= "</table>";

      return response()
              ->json(['Table' => $Table]);
    }

    public function API_Trainner(Request $request)
    {
      // Query DATA
      $DATA = DB::table('trainner_emp')->get();
      foreach ($DATA as $key => $row) {
        $option[] = "<option value='$row->tn_emp_id'>$row->fname $row->lname - $row->status_emp</option>";
      }

      return response()
              ->json(['option' => $option]);
    }

    





}
