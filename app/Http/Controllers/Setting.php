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

    public function Table_trainner_emp(Request $request)
    {
      $users = DB::table('trainner_emp')->select('*');
      return Datatables::of($users)
            ->addColumn('name_emp', function($users) {
                return $users->fname.' '.$users->lname;
            })  
            ->addColumn('action', function ($users) {
                $Data  = '<button class="btn btn-sm btn-warning" id="'.$users->tn_emp_id.'" onclick="Edit_Trainner_emp('.$users->tn_emp_id.');"><i class="fas fa-edit"></i></i>แก้ไข</button> ';
                return $Data;
            })   
            ->rawColumns(['action','name_emp'])                                            
            ->make(true);
    }

    public function Table_trainner(Request $request)
    {
      $users = DB::table('trainner')
              ->select('*')
              ->join('trainner_emp', 'trainner.tn_emp_id', '=', 'trainner_emp.tn_emp_id')
              ->join('item', 'trainner.class_id', '=', 'item.item_code');
      return Datatables::of($users)
            ->addColumn('name_emp', function($users) {
                return $users->fname.' '.$users->lname;
            })  
            ->editColumn('train_date', function($users) {
                return  date('d/m/Y', strtotime($users->train_date));
            }) 
            ->addColumn('repeat_status', function($users) {
                if ($users->enable_status == 'Y') {
                  $enable_status = '<span class="badge badge-success">เปิดการทำซ้ำ</span>';
                }else {
                  $enable_status = '<span class="badge badge-danger">ปิดการทำซ้ำ</span>';
                }
                // Repeat
                if ($users->repeat == 'Y') {
                  return '<span class="badge badge-success">ทำครั้งเดียว</span> / '.$enable_status;
                }elseif ($users->every_genday == 'Y') {
                  return '<span class="badge badge-success">ทำซ้ำตลอด</span> / '.$enable_status;
                }else {
                  return '<span class="badge badge-secondary">ไม่ทำซ้ำ</span> / '.$enable_status;
                }
            })
            ->addColumn('day_next', function($users) {
                $next_day = date('d/m/Y', strtotime("next ".$users->every_day));
                return  $next_day;
            }) 
            ->addColumn('action', function ($users) {
                if ($users->enable_status == 'Y') {
                $Data = '<button class="btn btn-sm btn-danger" id="'.$users->tn_id.'" ><i class="fas fa-comment-slash"></i>ปิดการทำซ้ำ</button> ';  
                }else {
                $Data = '';
                }
                return $Data;
            })  
            ->rawColumns(['name_emp','train_date','repeat_status','day_next','action'])                                            
            ->make(true);
    }

    public function Get_type_data(Request $request)
    {
      $Type = DB::table('type')->where('type_id', $request->post('type_id'))->get();
      foreach ($Type as $key => $row) {
        $Jsonencode = json_encode($row);
        echo $Jsonencode;
      }
    }

    public function Get_Trainner_emp_data(Request $request)
    {
      $Trainner_emp = DB::table('trainner_emp')->where('tn_emp_id', $request->post('tn_emp_id'))->get();
      foreach ($Trainner_emp as $key => $row) {
        $Jsonencode = json_encode($row);
        echo $Jsonencode;
      }
    }

    public function Add_Data_Type(Request $request)
    {
      DB::table('type')->insert(
          ['type_code' => $request->post('add_type_code'), 
           'type_recode' => $request->post('add_type_code'),
           'type_value' => $request->post('add_type_name'),
           'type_price' => $request->post('add_price'),
           'type_day' => $request->post('add_type_day'),
           'type_month' => $request->post('add_type_month'),
           'type_year' => $request->post('add_type_year'),
           'type_commitment' => $request->post('add_type_commitment'),
          ]
      );
      echo 'OK';
    }

    public function Edit_Data_Type(Request $request)
    {
      DB::table('type')
          ->where('type_id', $request->post('edit_id'))
          ->update([
           'type_code' => $request->post('edit_type_code'), 
           'type_recode' => $request->post('edit_type_code'),
           'type_value' => $request->post('edit_type_name'),
           'type_price' => $request->post('edit_price'),
           'type_day' => $request->post('edit_type_day'),
           'type_month' => $request->post('edit_type_month'),
           'type_year' => $request->post('edit_type_year'),
           'type_commitment' => $request->post('edit_type_commitment'),
          ]);
      echo 'OK';     
    }

    public function Save_Trainner_emp(Request $request)
    {
      DB::table('trainner_emp')->insert([
        'fname' => $request->post('firstname'), 
        'lname' => $request->post('lastname'),
        'status_emp' => $request->post('classname'),
      ]);
      echo 'OK';
    }

    public function Save_trainner(Request $request)
    {
      $Get_id = DB::table('trainner')->insertGetId([
        'tn_emp_id' => $request->post('select_trainner_emp_add'), 
        'train_date' => date('Y-m-d',strtotime(str_replace('/', '-', $request->post('date_trainner_add')))), 
        'class_id' => $request->post('select_trainner_class_add'), 
        'every_day' => $request->post('select_trainner_every_day'), 
        'train_time_start' => str_replace(' ', '', $request->post('input_trainner_time_start')), 
        'train_time_end' => str_replace(' ', '', $request->post('input_trainner_time_end')), 
      ]);
      // Update Status
      if ($request->post('radioValue') == 'repeat') {
        DB::table('trainner')
            ->where('tn_id', $Get_id)
            ->update(['repeat' => 'Y', 'enable_status' => 'Y']);
      }else if ($request->post('radioValue') == 'every_genday') {
        DB::table('trainner')
            ->where('tn_id', $Get_id)
            ->update(['every_genday' => 'Y', 'enable_status' => 'Y']);
      }else { echo 'No Update - ';}
      echo 'OK';
    }

    public function Save_edit_Trainner_emp(Request $request)
    {
      DB::table('trainner_emp')
        ->where('tn_emp_id', $request->post('id_emp'))
        ->update([
          'fname' => $request->post('firstname'),
          'lname' => $request->post('lastname'),
          'status_emp' => $request->post('classname')
        ]);
      echo 'OK';
    }

    public function Select_trianner_emp(Request $request)
    {
      // Trainner Emp
      $Trainner_emp = DB::table('trainner_emp')
                        ->where('status_emp', '<>' ,'Personal Trainer')
                        ->select('*')
                        ->get();
      $trainner_emp = "<select class='custom-select' id='select_trainner_emp_add'>";
      foreach ($Trainner_emp as $key => $row) {
        $trainner_emp .= "<option value='".$row->tn_emp_id."'>[".$row->status_emp."] ".$row->fname."  ".$row->lname."</option>";
      }
      $trainner_emp .= "</select>";
      // Type Class
      $Type_class = DB::table('item')
                        ->where('item_type', 'C')
                        ->select('*')
                        ->get();
      $type_class = "<select class='custom-select' id='select_trainner_class_add'>";
      foreach ($Type_class as $key => $row) {
        $type_class .= "<option value='".$row->item_code."'>[".$row->item_code."] ".$row->item_name."</option>";
      }
      $type_class .= "</select>";

      $ResArray = ['trainner_emp' => $trainner_emp, 'type_class' => $type_class];
      $Jsonencode = json_encode($ResArray);
      echo $Jsonencode;
    }

    
}