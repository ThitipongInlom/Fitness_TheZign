<?php

namespace App\Http\Controllers;

use App;
use Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
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

  public function Report_tab_1()
  {
    $restart = str_replace('/', '-', Input::post('start'));
    $reformat_start = date('Y-m-d', strtotime($restart));
    $reend = str_replace('/', '-', Input::post('end'));
    $reformat_end = date('Y-m-d', strtotime($reend));
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
    $Table .= "<div align='center'><b>ระหว่างวันที่ ".Input::post('start')." ถึงวันที่ ".Input::post('end')."</b></div>";
    $Table .= "<table class='table table-sm'>";
    $Table .= "<thead align='center'><tr><th>ลำดับ</th><th>รหัสสมาชิก</th><th>ชื่อนามสกุล</th><th>วันที่</th><th>เวลาเข้า</th><th>เวลาออก</th><th>รวมเป็นเวลา</th></tr></thead>";
    $Table .= "<tbody>";
    $i = 1;
    $member_count = 0;
    $hotel_count = 0;
    $gusetpass = 0;
    foreach ($DATA as $key => $row) {
      $Sumdate = date("H:i:s",(strtotime($row->Guset_out) - strtotime($row->Guset_in)));
      $Table .= "<tr align='center'><td>$i</td><td>$row->Code</td><td>$row->Name</td><td>".date('d/m/Y', strtotime($row->Guset_in))."</td><td>".date('H:i:s', strtotime($row->Guset_in))."</td><td>".date('H:i:s', strtotime($row->Guset_out))."</td><td>$Sumdate</td></tr>";
      $i++;
      if ($row->type == 'Hotel') {
        $hotel_count++;
      }elseif ($row->type == '1DM') {
        $gusetpass++;
      }else{
        $member_count++;
      }
    }
    $re_i = $i - 1 ;
    $Table .= "</tbody>";
    $Table .= "</table>";
    $Table .= "<hr>";
    $Table .= "<div class='container'><div class='row'><div class='col-md-12'>";
    $Table .= "<table class='table table-bordered table-sm'>";
    $Table .= "<thead align='center'><tr><th>จำนวน(คน)</th><th>Member</th><th>Hotel</th><th>Guest Pass</th><th>ผืนใหญ่</th><th>ผืนเล็ก</th><th>เสื้อคลุม</th></tr></thead>";
    $Table .= "<tbody><tr align='center'><td>$re_i</td><td>$member_count</td><td>$hotel_count</td><td>$gusetpass</td><td>$Sum_L3</td><td>$Sum_L1</td><td>$Sum_L2</td></tr></tbody>";
    $Table .= "</table>";
    $Table .= "</div></div></div>";
    // Encode To Json
    $arrayTable = array('Table' => $Table);
    $Jsonencode = json_encode($arrayTable);
    echo $Jsonencode;
    }




}
