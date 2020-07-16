<?php

namespace App\Http\Controllers;

use App;
use Config;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB as DB;

class MainCovid extends Controller
{
    public function MainCovid()
    {
      return view('MainCovid');
    }

    public function Data(Request $request)
    {
      DB::statement(DB::raw('set @rownum=0'));
      $users = DB::table('member')
                ->select([
                  DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                  "id",
                  "code",
                  "name",
                  "start",
                  "expire",
                  "phone",
                  "type_detail",
                  "type",
                  "address",
                  "status",
                  "daystop",
                  "fullprice",
                  "alldis",
                  "remark",
                  "resultprice",
                  "user_seting",
                  "today",
                  "wifiusername",
                  "wifipassword",
                  "wifidate",
                  "birthday",
                  "Img",
                  "id_card",
                  "document_img",
                  "document_file",
                  "covid_returnday",
                ]);
      return Datatables::of($users)
      ->filter(function ($query) use ($request) {
          if ($request->has('searchingcode')) {
              if ($request->get('searchingselect') == 'Active') {
                $query->where('expire', '>', "2020-03-14");
                $query->where('start', '<', "2020-03-14");
                $query->where('covid_returnday', '=' , null);
                $query->where('type', '<>', '1D');
                $query->where('code', 'not like', "H%");
              if($request->get('searchingcode') != null){
                $query->where('expire', '>', "2020-03-14");
                $query->where('start', '<', "2020-03-14");
                $query->where('covid_returnday', '=' , null);
                $query->where('type', '<>', '1D');
                $query->where('code', 'like', "%{$request->get('searchingcode')}%");
                $query->orWhere('name', 'like', "%{$request->get('searchingcode')}%");   
              }            
              }elseif($request->get('searchingselect') == 'Expired'){
                $query->where('code', 'not like', "H%");
              if($request->get('searchingcode') != null){
                $query->where('code', 'like', "%{$request->get('searchingcode')}%");
                $query->orWhere('name', 'like', "%{$request->get('searchingcode')}%");   
              }  
              }elseif($request->get('searchingselect') == 'Hotel'){
                $query->where('code', 'like', "H%");
                $query->where('code', 'like', "%{$request->get('searchingcode')}%");
                $query->orWhere('name', 'like', "%{$request->get('searchingcode')}%");                    
              }else{
                $query->where('code', 'like', "%{$request->get('searchingcode')}%");
                $query->orWhere('name', 'like', "%{$request->get('searchingcode')}%");              
              }
          }
          if ($request->has('searchingselect')) {
              if ($request->get('searchingselect') == 'Active') {
                $query->where('status', "Active");
                $query->where('type', '<>', 'Hotel');
              }elseif($request->get('searchingselect') == 'Expired'){
                $query->where('status', "Expired");
                $query->where('type', '<>', 'Hotel');               
              }elseif ($request->get('searchingselect') == 'Hotel') {
                $query->where('type', '=', 'Hotel');
              }else{
                $query->where('type', '<>', 'Hotel');
                // Status All
              }
          }
      })
      ->setRowClass(function ($users) {
              if ($users->status == 'Active') {
                  $FormatToDay = date('d-m');
                  $FormatBirthday = date('d-m', strtotime($users->birthday));
                  if ($users->status == 'Active' AND $FormatBirthday == $FormatToDay) {
                    $reclass = "devcon-badge";
                  }else{
                    $reclass = $users->rownum % 2 == 0 ? 'bg-tablecolor_set' : 'bg-tablecolor';
                  }
              }elseif ($users->status == 'Expired') {
                  $reclass = "bg_member_expired";
              }else{
                  $reclass = "";
              }
          return $reclass;
      })
      ->editColumn('name', '{!! str_limit($name, 30) !!}')
      ->editColumn('address', '{!! str_limit($address, 30) !!}')
      ->editColumn('start', function($users) {
          return date('d/m/Y', strtotime($users->start));
      })
      ->editColumn('expire', function($users) {
          return date('d/m/Y', strtotime($users->expire));
      })
      ->editColumn('status', function($users) {
          $icon = $users->status == 'Active' ? '<i class="far fa-check-circle" style="color:green; font-size:15px;"></i>':'<i class="far fa-times-circle" style="color:#5f0101; font-size:15px;"></i>';
          return $users->status.' '.$icon;
      })
      ->editColumn('birthday', function($users) {
          if ($users->birthday == '0000-00-00' OR $users->birthday == '1970-01-01') {
            $rebirthday = "-";
          }else{
            $rebirthday = date('d/m/Y', strtotime($users->birthday));
          }
          return $rebirthday;
      })
      ->addColumn('covid_plusday', function ($users) {
        $plus_day = date_diff(date_create("2020-03-14"),date_create($users->expire));
        return $plus_day->format("%a days");
      })
      ->addColumn('action', function ($users) {
        $plus_day = date_diff(date_create("2020-03-14"),date_create($users->expire));
        $Data  = '<button class="btn btn-sm btn-success" start="'.$users->start.'"  expire="'.$users->expire.'" data="'.$plus_day->format("%a").'" id="'.$users->code.'" onclick="ViewData_Covid(this)" data-toggle="tooltip" data-placement="left" title="ดูข้อมูล Code : '.$users->code.'"><i class="fas fa-search"></i>View</button> ';
        return $Data;
      })
      ->rawColumns(['status','action'])
      ->make(true);
  }

  public function Save_Viewdata_Covid(Request $request)
  {
    if($request->post('month_covid') == '3') {
      $covid_days = "90";
    }else if ($request->post('month_covid') == '4') {
      $covid_days = "120";
    }else {
      $covid_days = "0";
    }

    $new_covid_days = $request->post('days') + $covid_days;

    $start_covid = str_replace('/', '-', $request->post('start_covid'));
    $start_covid_date = date('Y-m-d', strtotime($start_covid));

    $date_new = strtotime($start_covid_date);
    $date_new = strtotime("+".$new_covid_days."day", $date_new);
    $date_new = date('Y-m-d', $date_new);
    // ต่อายุการใช้งาน Covid
    DB::table('member')
    ->where('code', $request->post('member_id'))
    ->update(['expire' => $date_new, 'covid_returnday' => 'Y']);
    $this->Insert_Member_Detail($request->post('member_id'),'ผลกระทบ Covid', $date_new, $request->post('month_covid')."M");
    // Show Json
    $array = array('Code' => $request->post('member_id'));
    $json = json_encode($array);
    echo $json;
  }

    public function Insert_Member_Detail($Code,$Note,$covid_expire,$covid_type)
    {
        date_default_timezone_set("Asia/Bangkok");
        $username = Session::get('Login.username');
        $Today = date("Y-m-d h:i:s");
        $Data = DB::table('member')->where('code', $Code)->get();
        foreach ($Data as $key => $row) {
          $Data_Type = DB::table('type')->where('type_code', $row->type)->get();
          foreach ($Data_Type as $key => $Type) {
            $commitment = $Type->type_commitment;
          }
          // Insert To DB Member_Detail
          DB::table('member_detail')->insert([
          'code' =>      $row->code,
          'name' =>      $row->name,
          'start' =>     $row->start,
          'expire' =>    $covid_expire,
          'phone' =>     $row->phone,
          'type' =>      $covid_type,
          'address' =>   $row->address,
          'status' =>    $row->status,
          'daystop' =>   '0',
          'fullprice' => '0',
          'alldis' =>    '0',
          'remark' =>    $row->remark,
          'resultprice' => '0',
          'user_seting' => $username,
          'today' => $Today,
          'typestatus' => $Note,
          'type_commitment' => $commitment,
          'birthday' => $row->birthday,
          ]);
        }
        return;
    }

}
