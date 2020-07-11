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
                $query->where('expire', '>', "2020-03-30");
                $query->where('covid_returnday', '=' , null);
                $query->where('code', 'not like', "H%");
              if($request->get('searchingcode') != null){
                $query->where('expire', '>', "2020-03-30");
                $query->where('covid_returnday', '=' , null);
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
        $date1 = date_create("2020-03-30");
        $date2 = date_create($users->expire);
        $plus_day = date_diff($date1,$date2);
        return $plus_day->format("%a days");
      })
      ->addColumn('action', function ($users) {
        $date1 = date_create("2020-03-30");
        $date2 = date_create($users->expire);
        $plus_day = date_diff($date1,$date2);
        $Data  = '<button class="btn btn-sm btn-success" expire="'.$users->expire.'" data="'.$plus_day->format("%a").'" id="'.$users->code.'" onclick="ViewData_Covid(this)" data-toggle="tooltip" data-placement="left" title="ดูข้อมูล Code : '.$users->code.'"><i class="fas fa-search"></i>View</button> ';
        return $Data;
      })
      ->rawColumns(['status','action'])
      ->make(true);
  }
}
