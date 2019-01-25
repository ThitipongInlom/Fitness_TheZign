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

class Setting extends Controller
{
    public function Setting()
    {
      return view('Setting');
    }

    public function Table_tab_1(Request $request)
    {
      $users = DB::table('type')
               ->select('*')
               ->orderBy('type_id', 'asc');
      return Datatables::of($users)
            ->editColumn('type_day', function($users) {
                return $users->type_day.' วัน';
            })
            ->editColumn('type_month', function($users) {
                return $users->type_month.' เดือน';
            })     
            ->editColumn('type_year', function($users) {
                return $users->type_year.' ปี';
            })  
            ->editColumn('type_price', function($users) {
                return $users->type_price.'฿';
            })  
            ->editColumn('type_commitment', function($users) {
                if($users->type_commitment == '0'){
                  $data_res = "ไม่มีสิทธิ์";
                }else{
                  $data_res = "มีสิทธิ์";
                }
                return $data_res;
            })              
            ->addColumn('action', function ($users) {
                $Data  = '<button class="btn btn-sm btn-warning" id="'.$users->type_id.'" onclick="Edit_Type('.$users->type_id.');"><i class="fas fa-edit"></i></i>แก้ไข</button> ';
                return $Data;
            })   
            ->rawColumns(['action'])                                            
            ->make(true);
    }

    
}