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
      $api_db = DB::table('api_db')->where('key','Airlink')->get();
      $connect = DB::table('connect')->where('connect_id','1')->value('connect_detail');
      return view('Setting',[
            'api_db' => $api_db,
            'connect' => $connect]);
    }

    public function Auto_Check_and_insert_trainner()
    {
      date_default_timezone_set("Asia/Bangkok");
      $today = now();
      $trainner = DB::table('trainner')
                    ->whereNull('autocheck')
                    ->get();
      foreach ($trainner as $key => $row) {

          // ถ้า ทำ ซ้ำแค่ครั้งเดียว 
          if($row->repeat == 'Y' AND $row->enable_status == 'Y') {
            $train_date = date("Y-m-d",strtotime($row->train_date.'+1 week'));
            DB::table('trainner')->insert([
              'tn_emp_id' => $row->tn_emp_id,
              'train_date' => $train_date,
              'class_id' => $row->class_id, 
              'every_day' => $row->every_day,
              'train_time_start' => $row->train_time_start,
              'train_time_end' => $row->train_time_end,
            ]);
            DB::table('trainner')
            ->where('tn_id', $row->tn_id)
            ->update(['enable_status' => NULL,'autocheck' => 'Y', 'auto_today' => $today]);
          }
          // ถ้า ทำ ซ้ำทุกครั้ง
          elseif ($row->every_genday == 'Y' AND $row->enable_status == 'Y') {
            $train_date = date("Y-m-d",strtotime($row->train_date.'+1 week'));
            $today = date('Y-m-d');
            if ($today == $row->train_date) {
            DB::table('trainner')->insert([
              'tn_emp_id' => $row->tn_emp_id,
              'train_date' => $train_date,
              'class_id' => $row->class_id, 
              'every_day' => $row->every_day,
              'train_time_start' => $row->train_time_start,
              'train_time_end' => $row->train_time_end,
              'every_genday' => 'Y',
              'enable_status' => 'Y'
            ]);            
            DB::table('trainner')
            ->where('tn_id', $row->tn_id)
            ->update(['enable_status' => NULL,'autocheck' => 'Y', 'auto_today' => $today]);
            }
          }
          // ถ้า ไม่ทำซ้ำ
          else {
            DB::table('trainner')
            ->where('tn_id', $row->tn_id)
            ->update(['autocheck' => 'Y', 'auto_today' => $today]);
          }

          print_r($row);
          echo '<br>';
      }
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
            ->addColumn('switch', function($users) {
                $check = $users->type_eye_hide == 'on' ? 'checked':'';
                $html  = "<label class='switch' style='margin-bottom: 0rem !important;'>";
                $html .= "<input type='checkbox' class='primary' $check typeid='$users->type_id' codetype='$users->type_code' onchange='onchange_switch_type(this)'>";
                $html .= "<span class='slider round'></span>";
                $html .= "</label>";
                return $html;
            })            
            ->addColumn('action', function ($users) {
                $Data  = '<button class="btn btn-sm btn-warning" id="'.$users->type_id.'" onclick="Edit_Type('.$users->type_id.');" data-toggle="tooltip" data-placement="left" title="แก้ไข '.$users->type_code.'"><i class="fas fa-edit"></i></i>แก้ไข</button> ';
                return $Data;
            })   
            ->rawColumns(['switch', 'action'])                                            
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
      $today = date('Y-m-d', strtotime("-1 day", strtotime(now())));
      $users = DB::table('trainner')
              ->select('*')
              ->where('trainner.train_date', '>', $today)
              ->join('trainner_emp', 'trainner.tn_emp_id', '=', 'trainner_emp.tn_emp_id')
              ->join('item', 'trainner.class_id', '=', 'item.item_code');
      return Datatables::of($users)
            ->setRowClass(function ($users) {
              $today = date('Y-m-d');
              if ($users->enable_status == 'Y') {
                return 'bg-warning';
              }elseif ($users->train_date == $today) {
                return 'bg-success';
              }elseif ($users->enable_status == Null) {
                return 'bg-secondary';
              }
            })
            ->addColumn('name_emp', function($users) {
                return $users->fname.' '.$users->lname;
            })  
            ->editColumn('train_date', function($users) {
                return  date('d/m/Y', strtotime($users->train_date));
            }) 
            ->addColumn('day_next', function($users) {
                $next_day = date('d/m/Y', strtotime("next ".$users->every_day));
                return  $next_day;
            }) 
            ->addColumn('train_time_sum', function($users) {
                $train_time_sum = $users->train_time_start.' - '.$users->train_time_end;
                return  $train_time_sum;
            }) 
            ->addColumn('action', function ($users) {
                $Data  = '<button class="btn btn-sm btn-primary" id="'.$users->tn_id.'" onclick="Edit_trainner(this);"><i class="fas fa-edit"></i></i> แก้ไข</button> 
                          <button class="btn btn-sm btn-danger" trainner_id="'.$users->tn_id.'" onclick="Delete_trainner(this);"><i class="fas fa-trash-alt"></i> ลบ</button>';
                return $Data;
            })  
            ->rawColumns(['name_emp','train_date','train_time_sum','day_next','action'])                                            
            ->make(true);
    }

    public function Table_item(Request $request)
    {
      $item = DB::table('item')->select('*');
      return Datatables::of($item)
            ->addColumn('action', function ($item) {
                $Data  = '<button class="btn btn-sm btn-warning" onclick=""><i class="fas fa-edit"></i></i>แก้ไข</button> ';
                return $Data;
            })   
            ->rawColumns(['action','name_emp'])                                            
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

    public function Get_data_trainner(Request $request)
    {
      $Trainner = DB::table('trainner')->where('tn_id', $request->post('trainner_id'))->get();
      $trainnerid = $request->post('trainner_id');
      foreach ($Trainner as $key => $row) {
      if ($row->repeat == 'Y') {
        $radio_select = 'repeat';
      }elseif ($row->every_genday == 'Y') {
        $radio_select = 'every_genday';
      }else{
        $radio_select = 'no';
      }
      // Trainner Emp
      $Trainner_emp = DB::table('trainner_emp')
                        ->where('status_emp', '<>' ,'Personal Trainer')
                        ->select('*')
                        ->get();
      $trainner_emp = "<select class='custom-select' id='modal_trainner_emp_edit'>";
      foreach ($Trainner_emp as $key => $row2) {
        if($row2->tn_emp_id == $row->tn_emp_id) {
          $trainner_emp .= "<option value='".$row2->tn_emp_id."' selected='selected'>[".$row2->status_emp."] ".$row2->fname."  ".$row2->lname."</option>";
        }else{
          $trainner_emp .= "<option value='".$row2->tn_emp_id."'>[".$row2->status_emp."] ".$row2->fname."  ".$row2->lname."</option>";
        }
      }
      $trainner_emp .= "</select>";
      // Type Class
      $Type_class = DB::table('item')
                        ->where('item_type', 'C')
                        ->select('*')
                        ->get();
      $type_class = "<select class='custom-select' id='modal_trainner_class_edit'>";
      foreach ($Type_class as $key => $row3) {
        if($row3->item_code == $row->class_id) {
          $type_class .= "<option value='".$row3->item_code."' selected='selected'>[".$row3->item_code."] ".$row3->item_name."</option>";
        }else{
          $type_class .= "<option value='".$row3->item_code."'>[".$row3->item_code."] ".$row3->item_name."</option>";
        }
      }
      $type_class .= "</select><input type='hidden' id='trainnerid_edit_model' value='$trainnerid'>";
      $ResArray = ['Data' => $row,'radio_select' => $radio_select,'trainner_emp' => $trainner_emp, 'type_class' => $type_class];
      $Jsonencode = json_encode($ResArray);
      echo $Jsonencode;
      }
    }

    public function Save_trainner_edit(Request $request)
    {
      date_default_timezone_set("Asia/Bangkok");
      $today = now();
      if ($request->post('Radios_edit') == 'repeat') {
      DB::table('trainner')
          ->where('tn_id', $request->post('trainnerid_edit_model'))
          ->update([
           'tn_emp_id' => $request->post('modal_trainner_emp_edit'), 
           'class_id' => $request->post('modal_trainner_class_edit'),
           'repeat' => 'Y',
           'every_genday' => NULL,
           'train_time_start' => str_replace(' ', '', $request->post('input_trainner_time_start_edit')),
           'train_time_end' => str_replace(' ', '', $request->post('input_trainner_time_end_edit')),
           'enable_status' => 'Y',
           'autocheck' => NULL,
           'auto_today' => NULL,
          ]);    
        if ($request->post('date_trainner_edit') != '') {
          $train_date = date('Y-m-d',strtotime(str_replace('/', '-', $request->post('date_trainner_edit'))));
          $every_day = date("l", strtotime($train_date));
          DB::table('trainner')
              ->where('tn_id', $request->post('trainnerid_edit_model'))
              ->update([
              'train_date' => $train_date, 
              'every_day' => $every_day,
              ]); 
        }
      }elseif ($request->post('Radios_edit') == 'every_genday') {
      DB::table('trainner')
          ->where('tn_id', $request->post('trainnerid_edit_model'))
          ->update([
           'tn_emp_id' => $request->post('modal_trainner_emp_edit'), 
           'class_id' => $request->post('modal_trainner_class_edit'),
           'repeat' => NULL,
           'every_genday' => 'Y',
           'train_time_start' => str_replace(' ', '', $request->post('input_trainner_time_start_edit')),
           'train_time_end' => str_replace(' ', '', $request->post('input_trainner_time_end_edit')),
           'enable_status' => 'Y',
           'autocheck' => NULL,
           'auto_today' => NULL,
          ]);    
        if ($request->post('date_trainner_edit') != '') {
          $train_date = date('Y-m-d',strtotime(str_replace('/', '-', $request->post('date_trainner_edit'))));
          $every_day = date("l", strtotime($train_date));
          DB::table('trainner')
              ->where('tn_id', $request->post('trainnerid_edit_model'))
              ->update([
              'train_date' => $train_date, 
              'every_day' => $every_day,
              ]); 
        }
      }else{
      DB::table('trainner')
          ->where('tn_id', $request->post('trainnerid_edit_model'))
          ->update([
           'tn_emp_id' => $request->post('modal_trainner_emp_edit'), 
           'class_id' => $request->post('modal_trainner_class_edit'),
           'repeat' => NULL,
           'every_genday' => NULL,
           'train_time_start' => str_replace(' ', '', $request->post('input_trainner_time_start_edit')),
           'train_time_end' => str_replace(' ', '', $request->post('input_trainner_time_end_edit')),
           'enable_status' => NULL,
           'autocheck' => NULL,
           'auto_today' => NULL,
          ]);    
        if ($request->post('date_trainner_edit') != '') {
          $train_date = date('Y-m-d',strtotime(str_replace('/', '-', $request->post('date_trainner_edit'))));
          $every_day = date("l", strtotime($train_date));
          DB::table('trainner')
              ->where('tn_id', $request->post('trainnerid_edit_model'))
              ->update([
              'train_date' => $train_date, 
              'every_day' => $every_day,
              ]); 
        }
      }
      echo 'OK';
    }

    public function Delete_trainner(Request $request)
    {
      DB::table('trainner')->where('tn_id', '=', $request->post('trainner_id'))->delete();
      echo 'OK';
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
           'type_pt_free' => $request->post('add_free_sum_package'),
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
           'type_pt_free' => $request->post('edit_free_sum_package'),
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
      $train_date = date('Y-m-d',strtotime(str_replace('/', '-', $request->post('date_trainner_add'))));
      $every_day = date("l", strtotime($train_date));
      $Get_id = DB::table('trainner')->insertGetId([
        'tn_emp_id' => $request->post('select_trainner_emp_add'), 
        'train_date' => $train_date, 
        'class_id' => $request->post('select_trainner_class_add'), 
        'every_day' => $every_day, 
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

    public function onchange_switch_type(Request $request)
    {
      DB::table('type')
        ->where('type_id', $request->post('type_id'))
        ->update(['type_eye_hide' => $request->post('value')]);

      return response()->json([
          'type' => 'success',
          'title' => "อัพเดต สถานะ ".$request->post('codetype')." เสร็จสิ้น"
      ]);
    }

    
}