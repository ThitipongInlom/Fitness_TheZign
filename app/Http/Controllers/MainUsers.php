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

class MainUsers extends Controller
{
    public function MainUsers()
    {
      return view('MainUsers');
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
                    ]);
        return Datatables::of($users)
        ->filter(function ($query) use ($request) {
            if ($request->has('searchingcode')) {
                if ($request->get('searchingselect') == 'Active') {
                $query->where('code', 'not like', "H%");
                if($request->get('searchingcode') != null){
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
        ->addColumn('action', function ($users) {
            $Data  = '<button class="btn btn-sm btn-success" id="'.$users->code.'" onclick="ViewData(this)" data-toggle="tooltip" data-placement="left" title="ดูข้อมูล Code : '.$users->code.'"><i class="fas fa-search"></i>View</button> ';
            return $Data;
        })
        ->rawColumns(['status','action'])
        ->make(true);
    }

    public function Model_code_viewdata(Request $request)
    {
      $users = DB::table('member_detail')
                ->select('*')
                ->where('code', '=', $request->post('model_code_viewdata'))
                ->orderBy('id', 'desc');
      return Datatables::of($users)
      ->editColumn('name', '{!! str_limit($name, 25) !!}')
      ->editColumn('start', function($users) {
          return date('d/m/Y', strtotime($users->start));
      })
      ->editColumn('expire', function($users) {
          return date('d/m/Y', strtotime($users->expire));
      })
      ->editColumn('fullprice', function($users) {
          if ($users->fullprice == '') {
          return  'ไม่ทราบราคา';
          }else{
          return  $users->fullprice.' ฿';
          }
      })
      ->editColumn('alldis', function($users) {
          if ($users->alldis == '') {
          return  'ไม่มีส่วนลด';
          }else{
          return  $users->alldis.' ฿';
          }
      })
      ->editColumn('resultprice', function($users) {
          if ($users->resultprice == '') {
          return  'ไม่ทราบราคา';
          }else{
          return  $users->resultprice.' ฿';
          }
      })
      ->rawColumns(['fullprice','alldis','resultprice'])
      ->make(true);
    }

    public function ViewData()
    {
        $id = Input::post('id');
        $Data = DB::table('member')->where('code', $id)->get();
        $Datatype = DB::table('type')->where('type_eye_hide', '<>', 'off')->get();
        foreach ($Data as $key => $row) {
        $View  = "<div class='row'>";
        $View .= "<div class='col-md-9'>";
        $View .= "<div class='card'>
        <div class='card-header' style='padding: 5px 5px;'>
            <h5>ข้อมูลทั่วไปของคุณ: $row->name</h5>
        </div>
          <input type='hidden' id='model_code_viewdata' value='$row->code'>
          <div class='card-body table-responsive p-0'>
            <table class='table table-sm table-hover'>
                  <tbody>
                  <tr>
                    <th align='left'>Code:</th>
                    <th align='center'>$row->code</th>
                    <th align='left'>สถานะ:</th>
                    <th align='center'>$row->status</th>
                    <th align='left'>ประเภท:</th>
                    <th align='center'>$row->type</th>
                  </tr>
                  <tr>
                    <th align='left'>วันที่เริ่มต้น:</th>
                    <th align='center' colspan='2'>";
                    if ($row->start == '0000-00-00') {
                      $View .= "ยังไม่มีข้อมูล";
                    }else{
                      $Restart = str_replace('-', '/', $row->start);
                      $reformat_start = date('d/m/Y', strtotime($Restart));
                      $View .= "$reformat_start";
                    }
         $View .= "</th>
                    <th align='left'>วันที่สิ้นสุด:</th>
                    <th align='center' colspan='2'>";
                    if ($row->expire == '0000-00-00') {
                      $View .= "ยังไม่มีข้อมูล";
                    }else{
                      $Reexpire = str_replace('-', '/', $row->expire);
                      $reformat_expire = date('d/m/Y', strtotime($Reexpire));
                      $View .= "$reformat_expire";
                    }
         $View .= "</th>
                  </tr>
                  <tr>
                    <th align='left'>วันเกิด:</th>
                    <th align='center' colspan='2'>";
                    if ($row->birthday == '0000-00-00') {
                      $View .= "ยังไม่มีข้อมูล";
                    }else{
                      $Rebirthday = str_replace('-', '/', $row->birthday);
                      $reformat_birthday = date('d/m/Y', strtotime($Rebirthday));
                      $View .= "$reformat_birthday";
                    }
          $View .= "</th>
                    <th align='left'>เบอร์โทร::</th>
                    <th align='center' colspan='2'>$row->phone</th>
                  </tr>
                  <tr>
                    <th align='left'>ที่อยู่:</th>
                    <th colspan='5'><textarea class='form-control' placeholder='ที่อยู่ของลูกค้า' rows='2' disabled>$row->address</textarea></th>
                  </tr>
                </tbody>
            </table>
          </div>
        </div>";
        $View .= "</div>";
        $View .= "<div class='col-md-3'>";
        if ($row->Img != '' OR $row->card_img != '') {
          if ($row->Img != '') {
            $View .= "<img style='width: 200px; height: 200px;' src='./img/$row->Img' alt='Img' class='img-thumbnail'>";
          }else{
            $View .= "<img style='width: 200px; height: 200px;' src='$row->card_img' alt='Img' class='img-thumbnail'>";
          }
        }else{
        $View .= "<img style='width: 200px; height: 200px;' src='./img/default.svg' alt='Img' class='img-thumbnail'>";
        }
        $View .= "<p></p>
                  <div class='upload-btn-wrapper' data-toggle='tooltip' data-placement='bottom' title='อัพโหลด รูปภาพ'>
                  <button class='btn btn-sm btn-primary' data-toggle='tooltip' data-placement='bottom' title='อัพโหลด รูปภาพ'>อัพโหลด รูปภาพ</button>
                  <input type='file' id='imguploadfile' onchange='uploadimguser(this);' code='$row->code' user_id='$row->id'>
                  </div></div>";
        // End Row
        $View .= "</div>";
        // Footer
        $View .= "<div class='row'>";
        $View .= "<div class='col-md-12'>";
        $View .= '<nav>
                  <div class="nav nav-tabs" id="nav-tab" role="tablist">
                  <a class="nav-item nav-link active" id="nav-extend-tab" data-toggle="tab" href="#nav-extend" role="tab" aria-controls="nav-extend" aria-selected="true">ต่ออายุการใช้งาน</a>
                  <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">รหัสWiFiลูกค้า</a>
                  <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">ประวัติการใช้บริการ</a>
                  <a class="nav-item nav-link" id="nav-editprofile-tab" data-toggle="tab" href="#nav-editprofile" role="tab" aria-controls="nav-editprofile" aria-selected="false">แก้ไขข้อมูลูกค้า</a>
                  <a class="nav-item nav-link" id="nav-document-tab" data-toggle="tab" href="#nav-document" role="tab" aria-controls="nav-document" aria-selected="false">เอกสารแน็บไฟล์</a>
                  </div>
                  </nav>';

      $View .=  "<div class='tab-content' id='nav-tabContent'>
                  <div class='tab-pane fade show active' id='nav-extend' role='tabpanel' aria-labelledby='nav-extend-tab'>
                  <table class='table table-sm table-bordered'>
                  <tr align='center'>
                    <td>
                      <div class='row'>
                        <label for='remember_reconnent_start' class='col-sm-4 col-form-label'>วันที่เริ่มต้น:</label>
                        <div class='col-sm-8'>
                          <div class='input-group' id='date_modal_start'>
                            <input type='text' style='margin-top:5px;' data-date-format='dd/mm/yyyy' data-position='right top' data-toggle='datepicker' class='form-control form-control-sm' id='remember_reconnent_start' placeholder='เลือกประเภทจะเพิ่มวันอัตโนมัติ'>
                            <div class='input-group-append'>
                              <button type='button' style='margin-top:5px;' class='btn btn-sm btn-outline-secondary docs-datepicker-trigger' disabled>
                                <i class='fa fa-calendar' aria-hidden='true'></i>
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </td>
                    <td>
                    <div class='row'>
                      <label for='remember_reconnent_end' class='col-sm-4 col-form-label'>วันที่สิ้นสุด:</label>
                      <div class='col-sm-8'>
                        <input type='text' style='margin-top:5px;' class='form-control form-control-sm' id='remember_reconnent_end' readonly placeholder='เลือกประเภทจะเพิ่มวันอัตโนมัติ'>
                      </div>
                    </div>
                    </td>
                  </tr>
                  <tr align='center'>
                    <td>
                    <div class='row'>
                      <label for='remember_reconnent_end' class='col-sm-4 col-form-label'>ต่ออายุ:</label>
                      <div class='col-sm-8'>
                        <select style='margin-top:5px;' class='custom-select custom-select-sm' onchange='Calculate_renewal(this)' id='remember_reconnent_type'>
                          <option selected value='0'>เลือกประเภท</option>";
                          foreach ($Datatype as $key => $Type) {
                            $View .= "<option value='$Type->type_code'>[ $Type->type_code ] $Type->type_value </option>";
                          }
      $View .=  "       </select>
                      </div>
                    </div>
                    </td>
                      <td>
                        <div class='row'>
                          <label for='remember_reconnent_price_full' class='col-sm-4 col-form-label'>ราคาปกติ:</label>
                          <div class='col-sm-8'>
                            <input type='text' style='margin-top:5px;' class='form-control form-control-sm' id='remember_reconnent_price_full' value='0'>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr align='center'>
                      <td>
                        <div class='row'>
                          <label for='remember_reconnent_remark' class='col-sm-4 col-form-label'>Remark:</label>
                          <div class='col-sm-8'>
                            <input type='text' style='margin-top:5px;' class='form-control form-control-sm' id='remember_reconnent_remark'>
                          </div>
                        </div>
                      </td>
                      <td>
                        <div class='row'>
                          <label for='remember_reconnent_discount' class='col-sm-4 col-form-label'>ส่วนลด:</label>
                          <div class='col-sm-8'>
                            <input type='text' style='margin-top:5px;' onchange='onchange_discount(this)' class='form-control form-control-sm' id='remember_reconnent_discount' value='0'>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr align='center'>
                      <td>
                        <div class='row'>
                          <label for='remember_reconnent_stopmb' class='col-sm-4 col-form-label'>STOPMB:</label>
                          <div class='col-sm-8'>
                            <input type='text' style='margin-top:5px;' class='form-control form-control-sm' start='$row->expire' onchange='StopMB(this);'  id='remember_reconnent_stopmb' disabled placeholder='คงเหลือ StopMB: $row->daystop วัน'>
                          </div>
                        </div>
                      </td>
                      <td>
                        <div class='row'>
                          <label for='remember_reconnent_price_total' class='col-sm-4 col-form-label'>ยอดชำระ:</label>
                          <div class='col-sm-8'>
                            <input type='text' style='margin-top:5px;' class='form-control form-control-sm' id='remember_reconnent_price_total' value='0'>
                          </div>
                        </div>
                      </td>
                    </tr>
                  </table>
                  <div algin='center'>
                    <button class='btn btn-sm btn-success' onclick='remember_reconnent_airlink(this)'>ยืนยันการต่ออายุ</button>
                  </div>
                  </div>";

      $View .=  "<div class='tab-pane fade' id='nav-profile' role='tabpanel' aria-labelledby='nav-profile-tab'>
                  <table class='table table-sm table-bordered'>
                    <tr>
                      <td align='center'><b>Username:</b></td>
                    <th>";
                      if ($row->wifiusername != '') {
                        $View .=  "<input type='text' class='form-control form-control-sm' disabled value='$row->wifiusername'>";
                      }else{
                        $View .=  "<input type='text' class='form-control form-control-sm' disabled value='ยังไม่มีข้อมูล Username'>";
                      }
      $View .=  "   </th>
                    <td align='center'><b>วันหมดอายุ:</b></td>
                    <th>";
                      if ($row->wifidate != '') {
                        if ($row->wifidate == '0000-00-00') {
                          $reformat_wifisuccess = 'ยังไม่มีข้อมูล วันที่สิ้นสุด';
                        }else{
                          $Rewididate = str_replace('-', '/', $row->wifidate);
                          $reformat_wifisuccess = date('d/m/Y', strtotime($Rewididate));
                        }
                        $View .=  "<input type='text' class='form-control form-control-sm' disabled value='$reformat_wifisuccess'>";
                      }else{
                        $View .=  "<input type='text' class='form-control form-control-sm' disabled value='ยังไม่มีข้อมูล วันที่สิ้นสุด'>";
                      }
      $View .=  "   </th>
                    </tr>
                    <tr>
                      <td align='center'><b>Password:</b></td>
                      <th>";
                      if ($row->wifipassword != '') {
                        $View .=  "<input type='text' class='form-control form-control-sm' disabled value='$row->wifipassword'>";
                      }else{
                        $View .=  "<input type='text' class='form-control form-control-sm' disabled value='ยังไม่มีข้อมูล Password'>";
                      }
        $View .=  " </th>
                      <th></th>
                      <th></th>
                    </tr>
                  </table>
                  </div>";

        $View .=  "<div class='tab-pane fade' id='nav-contact' role='tabpanel' aria-labelledby='nav-contact-tab'>
                  <div class='table-responsive'>
                  <table class='table table-sm dt-responsive nowrap  row-border table-bordered table-hover TableDisplay' cellspacing='0' cellpadding='0' id='TableDisplayDetail' width='100%'>
                      <thead>
                          <tr align='center' class='bg-primary'>
                              <th>ชื่อลูกค้า</th>
                              <th>วันที่เริ่มต้น</th>
                              <th>วันที่สิ้นสุด</th>
                              <th>สถานะ</th>
                              <th>ราคาเต็ม</th>
                              <th>ส่วนลด</th>
                              <th>ราคารวม</th>
                              <th>ประเภท</th>
                          </tr>
                      </thead>
                      <tfoot>
                          <tr align='center' class='bg-primary'>
                              <th>ชื่อลูกค้า</th>
                              <th>วันที่เริ่มต้น</th>
                              <th>วันที่สิ้นสุด</th>
                              <th>สถานะ</th>
                              <th>ราคาเต็ม</th>
                              <th>ส่วนลด</th>
                              <th>ราคารวม</th>
                              <th>ประเภท</th>
                          </tr>
                      </tfoot>
                  </table>
                  </div>
                  </div>";
        $View .=  "<div class='tab-pane fade' id='nav-editprofile' role='tabpanel' aria-labelledby='nav-editprofile-tab'>
                  <table class='table table-sm table-bordered' width='100%'>
                    <tr>
                     <td align='center'><b>แก้ไขวันเกิด</b></td>
                     <td><input type='text' data-date-format='dd/mm/yyyy' data-position='right top' data-toggle='datepicker' class='form-control form-control-sm' id='edit_birthday_input' placeholder='แก้ไขวันเกิด'></td>
                     <td align='center'><b>แก้ไขเบอร์ ลูกค้า</b></td>
                     <td><input type='text' class='form-control form-control-sm' id='edit_phone_input' placeholder='เปลี่ยนเบอร์โทร'></td>
                    </tr>
                    <tr>
                    <td align='center'><b>แก้ไข ที่อยู่</b></td>
                    <td colspan='3'>
                    <textarea class='form-control' id='edit_address_input' rows='2' placeholder='เปลี่ยนที่อยู่ลูกค้า'></textarea>
                    </td>
                    </tr>
                  </table>
                  <div align='center'><button class='btn btn-success btn-sm' onclick='editmember();'>อัพเดต</button></div>
                  </div>";

        $View .=  "<div class='tab-pane fade' id='nav-document' role='tabpanel' aria-labelledby='nav-document-tab'>
                    <div class='row mt-2'>
                      <div class='col-md-12'>
                        <div class='text-center'>
                          <div class='upload-btn-wrapper' data-toggle='tooltip' data-placement='bottom' title='เพิ่มรูปภาพ เอกสาร'>
                            <button class='btn btn-sm btn-success' data-toggle='tooltip' data-placement='bottom' title='เพิ่มรูปภาพ เอกสาร'>เพิ่มรูปภาพ เอกสาร</button>
                            <input type='file' id='modal_document_member_image' onchange='Upload_member_image_document();'>
                          </div>
                          <div class='upload-btn-wrapper' data-toggle='tooltip' data-placement='bottom' title='เพิ่มไฟล์ เอกสาร<'>
                            <button class='btn btn-sm btn-primary' data-toggle='tooltip' data-placement='bottom' title='เพิ่มไฟล์ เอกสาร<'>เพิ่มไฟล์ เอกสาร</button>
                            <input type='file' id='modal_document_member_file' onchange='Upload_member_file_document();'>
                          </div>
                        </div>
                        <table class='table table-sm table-bordered mt-2' id='modal_table_document' width='100%'>
                          <tr align='center'>
                            <th>ชื่อไฟล์</th>
                            <th>เครื่องมือ</th>
                          </tr>
                        </table>
                      </div>
                    </div>       
                  </div>";
        $View .= "</div>";
        $View .= "</div>";
        $View .= "</div>";
        }
        // Show Json
        $array = array('Table' => $View, 'Code' => $id);
        $json = json_encode($array);
        echo $json;
    }

    public function Calculate_renewal(Request $request)
    {
      if ($request->post('Type') != '0') {
        $date_now = date("Y-m-d");
        $date1 = str_replace('/', '-', $request->post('start'));
        if ($date1 != '') {
          $select_date = date('Y-m-d',strtotime($date1));
        }else{
          $select_date = $date_now;
        }
        $Data_member = DB::table('member')->where('code', $request->post('Code'))->get();
        foreach ($Data_member as $key => $member) {
          $start_member  = $member->start;
          $expire_member = $member->expire;
          $status_member = $member->status;
        }
        $Data_Type = DB::table('type')->where('type_code', $request->post('Type'))->get();
        foreach ($Data_Type as $key => $type) {
            $type_price = $type->type_price;
            $type_type_day = $type->type_day;
            $type_type_month = $type->type_month;
            $type_type_year = $type->type_year;
            $type_type_commitment = $type->type_commitment;
        }
        // Check Date Expire
        if ($status_member == 'Active') {
            $Modidy_Date_start = $expire_member;
            $Modidy_Date = $expire_member;
        }else{
            // Check Connect Status
            $Connect_Fixdate = DB::table('connect')->where('connect_id', '2')->get();
            foreach ($Connect_Fixdate as $key => $row) {
              $Connect_Fixdate = $row->connect_detail;
            }
            // ถ้า == 1 เลือกวันที่ไม่ได้
            if ($Connect_Fixdate == '1') {
              $Modidy_Date_start = $date_now;
              $Modidy_Date = $date_now;
            }else{
              $date_fix = str_replace('/', '-', $request->post('start'));
              $date_fix_start = $select_date;
              $Modidy_Date_start = $date_fix_start;
              $Modidy_Date = $date_fix;
            }
        }
        // Modifly Date
        $DateData = date_create($Modidy_Date);
        // Modifly Day + Day
        date_modify($DateData, '+'.$type_type_day.' day');
        // Modifly Month + Month
        date_modify($DateData, '+'.$type_type_month.' month');
        // Modifly Years + Years
        date_modify($DateData, '+'.$type_type_year.' years');
        $Reexpire = date_format($DateData, 'Y-m-d');
        // Modifly Date Format
        $formatstart = date('d/m/Y',strtotime($Modidy_Date_start));
        $formatexpire = date('d/m/Y',strtotime($Reexpire));
        // Data
        $ResArray = ['start' => $formatstart,'expire' => $formatexpire,'price' => $type_price];
        return \Response::json($ResArray);
      }else{
        $ResArray = ['start' => '','expire' => '','price' => '0'];
        return \Response::json($ResArray);
      }

    }

    public function Uploadimguser(Request $request)
    {
      $User_Id = $request->post('User_Id');
      $Code = $request->post('Code');
      $Image = $request->file('Img');
      $Data = DB::table('member')->where('id', $User_Id)->get();
      foreach ($Data as $key => $row) {
        if ($row->Img == '') {
          // Have FLIE
          if (isset($_FILES['Img']['name'])) {
              //Type Flie
              $TypeFile = pathinfo($_FILES['Img']['name'],PATHINFO_EXTENSION);
              // Name In Sha
              $Nowsha = sha1(now().$_FILES['Img']['name']);
              // Re Name Success
              $FlieNameSuccess = $Nowsha.'.'.$TypeFile;
              // Path To Save Img
              $DestinationPath = public_path('/img');
              $Image->move($DestinationPath, $FlieNameSuccess);
              DB::table('member')
                  ->where('id', $User_Id)
                  ->update(['Img' => $FlieNameSuccess]);
          }
        }else {
            if(file_exists(public_path("img/$row->Img"))){
              unlink(public_path("img/$row->Img"));
            }
            DB::table('member')
                ->where('id', $User_Id)
                ->update(['Img' => '']);
            // Have FLIE
            if (isset($_FILES['Img']['name'])) {
              //Type Flie
              $TypeFile = pathinfo($_FILES['Img']['name'],PATHINFO_EXTENSION);
              // Name In Sha
              $Nowsha = sha1(now().$_FILES['Img']['name']);
              // Re Name Success
              $FlieNameSuccess = $Nowsha.'.'.$TypeFile;
              // Path To Save Img
              $DestinationPath = public_path('/img');
              $Image->move($DestinationPath, $FlieNameSuccess);
              DB::table('member')
                  ->where('id', $User_Id)
                  ->update(['Img' => $FlieNameSuccess]);
            }
        }
      }
      $ResArray = ['text' => $Code];
      return \Response::json($ResArray);
    }

    public function Upload_member_document(Request $request)
    {
      $Code = $request->post('Code');
      $Image = $request->file('Img');
      // Have FLIE
      if (isset($_FILES['Img']['name'])) {
          //Type Flie
          $TypeFile = pathinfo($_FILES['Img']['name'],PATHINFO_EXTENSION);
          // Name In Sha
          $Nowsha = sha1(now().$_FILES['Img']['name']);
          // Re Name Success
          $FlieNameSuccess = $Nowsha.'.'.$TypeFile;
          // Path To Save Img
          $DestinationPath = public_path('/img');
          $Image->move($DestinationPath, $FlieNameSuccess);
          if ($request->post('type_update') == 'image') {
            DB::table('member')
                ->where('code', $Code)
                ->update(['document_img' => $FlieNameSuccess]);
          }else {
            DB::table('member')
                ->where('code', $Code)
                ->update(['document_file' => $FlieNameSuccess]);
          }
      }
      $ResArray = ['text' => $Code];
      return \Response::json($ResArray);
    }

    public static function GetTypeData()
    {
        $TypeData = DB::table('type')->where('type_eye_hide', '<>', 'off')->get();
        return $TypeData;
    }

    public static function Get_Total_UserIn($Data)
    {
       if ($Data == '0') {
         // Yesterday
         $date = date("m-d-Y");
         $date1 = str_replace('-', '/', $date);
         $Today = date('Y-m-d',strtotime($date1 . "-1 days"));
         $Data = DB::table('main_table')->where('date', $Today)->where('Status', 'OUT')->count();
       }elseif ($Data == '1') {
         // Today
         $Today = date("Y-m-d");
         $Data = DB::table('main_table')->where('date', $Today)->where('Status', 'OUT')->count();
       }elseif ($Data == '2') {
         // Online
         $Today = date("Y-m-d");
         $Data = DB::table('main_table')->where('date', $Today)->where('Status', 'IN')->count();
       }
       return $Data;
    }

    public static function Get_Data_UserIn($Data)
    {
        if ($Data == '0') {
          // Yesterday
          $date = date("m-d-Y");
          $date1 = str_replace('-', '/', $date);
          $Today = date('Y-m-d',strtotime($date1 . "-1 days"));
          $Data = DB::table('main_table')
            ->select('type', DB::raw('count(type) as total_type'))
            ->join('member', 'main_table.Code', '=', 'member.code')
            ->groupBy('type')
            ->where('date', $Today)
            ->where('main_table.Status', 'OUT')
            ->get();
        }elseif ($Data == '1') {
          $Today = date("Y-m-d");
          $Data = DB::table('main_table')
            ->select('type', DB::raw('count(type) as total_type'))
            ->join('member', 'main_table.Code', '=', 'member.code')
            ->groupBy('type')
            ->where('date', $Today)
            ->where('main_table.Status', 'OUT')
            ->get();
        }elseif ($Data == '2') {
          $Today = date("Y-m-d");
          $Data = DB::table('main_table')
            ->select('type', DB::raw('count(type) as total_type'))
            ->join('member', 'main_table.Code', '=', 'member.code')
            ->groupBy('type')
            ->where('date', $Today)
            ->where('main_table.Status', 'IN')
            ->get();
        }
        return $Data;
    }

    public function Airlink_modal_data(Request $request)
    {
        date_default_timezone_set("Asia/Bangkok");
        $Today = date("Y-m-d");
        $Valid = $Today;
        // connect DB
        $Airlink = $this->Set_DB_Airlink();
        $DataEpitome = DB::connection('apimysql')->table("voucher")
                       ->where('password', 'like' , $request->post('Text_Code').'%')
                       ->whereRaw("date_format(valid_until,'%Y-%m-%d') >= '$Valid'")
                       ->orderBy('id', 'desc')
                       ->limit(20)
                       ->get();

        function _unserialize($data){
          $data = @unserialize($data);
          if(is_array($data)){foreach($data as $key=>$val){if(is_string($val)){$data[$key]=str_replace('{{slash}}','',$val);}}return $data;}
          return (is_string($data)) ? str_replace('{{slash}}', '', $data) : $data;
        }
        // Table DATA
        $Table  = "<br><table class='table table-sm' style='font-size: 13px;'>";
        $Table .= "<thead><tr align='center'><th>ห้องลูกค้า</th><th>ชื่อลูกค้า</th><th>เข้าพักถึงวันที่</th></tr></thead>";
        $Table .= "<tbody>";
        foreach ($DataEpitome as $key => $row) {
          $Profile = _unserialize($row->profile);
          $Today = date("Y-m-d h:i:s");
          $date1 = str_replace('T', ' ', $row->valid_until);
          $expire_date =  date('d/m/Y',strtotime($date1));
          $expire_datedata =  date('Y-m-d',strtotime($date1));
          $Table .= "<tr align='center'>";
          $Table .= "<td><span style='cursor: pointer;' onclick='Send_To_Register(this);' class='badge badge-pill badge-primary' account='".$Profile['personal_id']."' name='".$Profile['firstname']."' start='$Today' end='$expire_date' room='$row->password' phone='".$Profile['phone']."' username='$row->username'>$row->password</span></td>";
          $Table .= "<td align='left'>".$Profile['firstname']."</td>";
          $Table .= "<td>$expire_date</td>";
          $Table .= "</tr>";
        }
        $Table .= "</tbody>";
        $Table .= "</table>";

        $ResArray = ['Table' => $Table, 'SQL' => $DataEpitome, 'Valid' => $Profile];
        return \Response::json($ResArray);
    }

    public function Remember_reconnent_airlink(Request $request)
    {
        date_default_timezone_set("Asia/Bangkok");
        if ($request->post('start_date') != '') {
          // connect DB
          $Airlink = $this->Set_DB_Airlink();
          $username = $request->session()->get('Login.username');
          $Today = date("Y-m-d h:i:s");
          $Username_Airlink_H = DB::connection('apimysql')->table("voucher")->where('username', '=' , $request->post('code'))->count();
          // Check Connect Status
          $Connect_Status = DB::table('connect')->where('connect_id', '1')->get();
          foreach ($Connect_Status as $key => $row) {
            $Data_Connect_Status = $row->connect_detail;
          }
          // Free
          $remember_freepro = DB::table('type')->where('type_code', $request->post('type'))->get();
          foreach ($remember_freepro as $key => $row) {
            $type_pt_free = $row->type_pt_free;
          }
          if ($type_pt_free > '0') {
          DB::table('detail_table')->insert([
			      'code' => $request->post('code'),
			      'date_time' => $Today,
            'itemcode' => 'P',
			      'itemcodetype'  => 'P15',
			      'itemtype'  => 'T',
			      'itemname'  => 'โปรโมชั่น เทรนเนอร์ ฟรี',
			      'price'     => '0',
			      'sum'       => $type_pt_free,
          ]);
          $today = $Today;
          $date = date("Y-m-d");
          $code = $request->post('code');
          $itemcode = 'P';
          $itemtype = 'T';
          $itemname = 'โปรโมชั่น เทรนเนอร์ ฟรี';
          $itemprice= '0';
          $itemcodetype = 'P15';
          $itemsetnumber = $type_pt_free;
          // Insert Data Package Fake
          $fake_package = DB::table('fake_package')->insertGetId([
            'fake_code' => $code,
            'fake_datetime' => $today,
            'fake_itemcode' => $itemcode,
            'fake_typeitemcode' => $itemcodetype,
            'fake_typeitem' => $itemtype,
            'fake_itemname' => $itemname,
            'fake_price'    => $itemprice,
            'fake_sum'      => $itemsetnumber,
            'Status'        => 'BUY'
          ]);
          // Insert Data Package Main
          $package_detail_id = DB::table('package_detail')->insertGetId([
            'fake_code' => $code,
            'fake_datetime' => $today,
            'fake_itemcode' => $itemcode,
            'fake_typeitemcode' => $itemcodetype,
            'fake_typeitem' => $itemtype,
            'fake_itemname' => $itemname,
            'fake_price'    => $itemprice,
            'fake_sum'      => $itemsetnumber,
          ]);
          // Insert Package Main
          $idpackage = DB::table('main_package')->insertGetId([
            'main_package_id' => $package_detail_id,
            'Code' => $code,
            'date' => $date,
            'Status' => 'Active',
            'name_package' => $itemname,
            'total_sum' => $itemsetnumber,
            'have_sum' => $itemsetnumber]);
          // Update Main Id
          DB::table('fake_package')
              ->where('fake_code', $code)
              ->where('fake_package_id', $fake_package)
              ->update(['main_package_id' => $idpackage]);
          // Update Package Main
          DB::table('package_detail')
              ->where('fake_code', $code)
              ->where('package_id', $package_detail_id)
              ->update(['main_package_id' => $idpackage]);
          }

          if ($Data_Connect_Status == '0') {
              if ($Username_Airlink_H == '1') {
              // Get Data Type
              $Data_Type = DB::table('type')->where('type_code', $request->post('type'))->get();
              $Username_Code = $request->post('code');
              $Start_Str = str_replace('/', '-', $request->post('start_date'));
              $End_Str = str_replace('/', '-', $request->post('end_date'));
              $Start_Date = date("Y-m-d",strtotime($Start_Str));
              $End_Date = date("Y-m-d",strtotime($End_Str));
              $Valid = date("Y-m-d",strtotime($End_Str))."T23:59:59";
              $Expired = strftime("%B %d %Y",strtotime($End_Str))." 23:59:59";
              $Type = $request->post('type');
              $STOP_MB = $request->post('stopmb');
              $Price_full = $request->post('price_full');
              $Discount = $request->post('discount');
              $Price_total = $request->post('price_total');
              // Have Username In Airlink
              // Update UserName radcheck Expiration
              DB::connection('apimysql')->table("radcheck")
              ->where('username', $Username_Code)
              ->where('attribute', 'Expiration')
              ->update(['value' => $Expired]);
              // Update UserName voucher
              DB::connection('apimysql')->table("voucher")
              ->where('username', $Username_Code)
              ->update(['valid_until' => $Valid]);
              // Update Member Date
              if ($Type == 'Stop') {
                $Data_StopMB = DB::table('member')->where('code', $Username_Code)->get();
                foreach ($Data_StopMB as $key => $row) {
                  $NumMB = $row->daystop - $STOP_MB;
                }
                DB::table('member')
                ->where('code', $Username_Code)
                ->update(
                ['expire' => $End_Date,
                 'status' => 'Active',
                 'daystop' => $NumMB,
                 'fullprice' => $Price_full,
                 'alldis' => $Discount,
                 'resultprice' => $Price_total,
                 'wifidate' => $End_Date,
                 'today' => $Today,
                ]);
                // Member_Detail
                $this->Insert_Member_Detail($Username_Code,'Stop Member');
              }else{
                DB::table('member')
                ->where('code', $Username_Code)
                ->update(
                ['start' => $Start_Date,
                 'expire' => $End_Date,
                 'type_detail' => $Type,
                 'type' => $Type,
                 'status' => 'Active',
                 'fullprice' => $Price_full,
                 'alldis' => $Discount,
                 'resultprice' => $Price_total,
                 'wifidate' => $End_Date,
                 'today' => $Today,
                ]);
                // Member_Detail
                $this->Insert_Member_Detail($Username_Code,'ต่ออายุการใช้งาน');
              }
              }else{
              // Not Have Username In Airlink
              $Data_Type = DB::table('type')->where('type_code', $request->post('type'))->get();
              $Username_Code = $request->post('code');
              $Password = rand(1,100000);
              $Start_Str = str_replace('/', '-', $request->post('start_date'));
              $End_Str = str_replace('/', '-', $request->post('end_date'));
              $Start_Date = date("Y-m-d",strtotime($Start_Str));
              $End_Date = date("Y-m-d",strtotime($End_Str));
              $Valid = date("Y-m-d",strtotime($End_Str))."T23:59:59";
              $Expired = strftime("%B %d %Y",strtotime($End_Str))." 23:59:59";
              $Type = $request->post('type');
              $STOP_MB = $request->post('stopmb');
              $Price_full = $request->post('price_full');
              $Discount = $request->post('discount');
              $Price_total = $request->post('price_total');
              $profile = $this->SetData($request->post('Name_Add'),$request->post('Phone_Add'));
              $Data_Billingplan = DB::connection('apimysql')->table("billingplan")->where('name', 'fitness')->get();
              foreach ($Data_Billingplan as $key => $row) {
                $Group = $row->groupname;
                $Ggroupname = $row->name;
                $Up = $row->bw_upload;
                $Down = $row->bw_download;
                $Re_url = $row->redirect_url;
                $Idle = $row->IdleTimeout;
                $Billplan = $row->name;
              }
              // Check Username In Airlink
              $Radusergroup = DB::connection('apimysql')->table("radusergroup")->where('username', $Username_Code)->count();
              // Insert UserName radcheck
              DB::connection('apimysql')->table("radcheck")->insert([
                  ['username' => $Username_Code, 'attribute' => 'Password', 'op' => ':=', 'value' => $Password],
                  ['username' => $Username_Code, 'attribute' => 'Expiration', 'op' => ':=', 'value' => $Expired],
                  ['username' => $Username_Code, 'attribute' => 'Auth-Type', 'op' => ':=', 'value' => 'Local']]);
              // Insert UserName radreply
              DB::connection('apimysql')->table("radreply")->insert([
                  ['username' => $Username_Code, 'attribute' => 'WISPr-Bandwidth-Max-Down', 'op' => ':=', 'value' => $Down],
                  ['username' => $Username_Code, 'attribute' => 'WISPr-Bandwidth-Max-Up', 'op' => ':=', 'value' => $Up],
                  ['username' => $Username_Code, 'attribute' => 'WISPr-Redirection-URL', 'op' => ':=', 'value' => $Re_url]]);
              // Insert UserName radusergroup
              DB::connection('apimysql')->table("radusergroup")->insert([
                  ['username' => $Username_Code, 'groupname' => $Group, 'priority' => '1']]);
              // Insert Username voucher
              DB::connection('apimysql')->table("voucher")->insert([ 
                  ['username' => $Username_Code,
                   'password' => $Password,
                   'billingplan' => $Billplan,
                   'created_by' => $username,
                   'IdleTimeout' => $Idle,
                   'valid_until' => $Valid,
                   'isprinted' => '0',
                   'profile' => $profile,
                   'encryption' => 'clear',
                   'money' => '0']]);
              //  Update UserName And Password To member
              DB::table('member')->where('id', $Username_Code)->update(['wifiusername' => $Username_Code,'wifipassword' => $Password, 'wifidate' => $End_Date]);
              DB::table('member')
                ->where('code', $Username_Code)
                ->update(
                ['start' => $Start_Date,
                 'expire' => $End_Date,
                 'type_detail' => $Type,
                 'type' => $Type,
                 'status' => 'Active',
                 'fullprice' => $Price_full,
                 'alldis' => $Discount,
                 'resultprice' => $Price_total,
                 'wifidate' => $End_Date,
                 'today' => $Today,
                ]);
                // Member_Detail
                $this->Insert_Member_Detail($Username_Code,'ต่ออายุการใช้งาน');
              }
          }else{
            $Data_Type = DB::table('type')->where('type_code', $request->post('type'))->get();
            $Username_Code = $request->post('code');
            $Start_Str = str_replace('/', '-', $request->post('start_date'));
            $End_Str = str_replace('/', '-', $request->post('end_date'));
            $Start_Date = date("Y-m-d",strtotime($Start_Str));
            $End_Date = date("Y-m-d",strtotime($End_Str));
            $Type = $request->post('type');
            $STOP_MB = $request->post('stopmb');
            $Price_full = $request->post('price_full');
            $Discount = $request->post('discount');
            $Price_total = $request->post('price_total');
            if ($Type == 'Stop') {
              // Stop MB
              $Data_StopMB = DB::table('member')->where('code', $Username_Code)->get();
              foreach ($Data_StopMB as $key => $row) {
                $NumMB = $row->daystop - $STOP_MB;
              }
              DB::table('member')
              ->where('code', $Username_Code)
              ->update(
              ['expire' => $End_Date,
               'daystop' => $NumMB,
               'fullprice' => $Price_full,
               'alldis' => $Discount,
               'resultprice' => $Price_total,
               'today' => $Today,
              ]);
              // Member_Detail
              $this->Insert_Member_Detail($Username_Code,'Stop Member');
            }else{
              $Data = DB::table('member')->where('code', $Username_Code)->get();
              foreach ($Data as $key => $row) {
                $Status = $row->status;
              }
              if ($Status == 'Active') {
              // ต่อายุการใช้งาน แบบ ใช้งานปกติ
              DB::table('member')
               ->where('code', $Username_Code)
               ->update(
               ['expire' => $End_Date,
                'type_detail' => $Type,
                'type' => $Type,
                'status' => 'Active',
                'fullprice' => $Price_full,
                'alldis' => $Discount,
                'resultprice' => $Price_total,
                'today' => $Today,
               ]);
              }else{
              // ต่อายุการใช้งาน แบบ หมดอายุ
               DB::table('member')
                ->where('code', $Username_Code)
                ->update(
                ['start' => $Start_Date,
                 'expire' => $End_Date,
                 'type_detail' => $Type,
                 'type' => $Type,
                 'status' => 'Active',
                 'fullprice' => $Price_full,
                 'alldis' => $Discount,
                 'resultprice' => $Price_total,
                 'today' => $Today,
                ]);
              }
              // Member_Detail
              $this->Insert_Member_Detail($Username_Code,'ต่ออายุการใช้งาน');
            }
          }
        }
    }

    public function Insert_Member_Detail($Code,$Note)
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
          'expire' =>    $row->expire,
          'phone' =>     $row->phone,
          'type' =>      $row->type,
          'address' =>   $row->address,
          'status' =>    $row->status,
          'daystop' =>   $row->daystop,
          'fullprice' => $row->fullprice,
          'alldis' =>    $row->alldis,
          'remark' =>    $row->remark,
          'resultprice' => $row->resultprice,
          'user_seting' => $username,
          'today' => $Today,
          'typestatus' => $Note,
          'type_commitment' => $commitment,
          'birthday' => $row->birthday,
          ]);
        }
        return;
    }

    public function SendToRegister(Request $request)
    {
        $username = $request->session()->get('Login.username');
        $Today = date("Y-m-d h:i:s");
        $Re_account = substr($request->post('account'),6);
        $name = $request->post('name');
        $start = $request->post('start');
        $restart = date('Y-m-d', strtotime($start));
        $end = str_replace('/', '-', $request->post('end'));
        $reend = date('Y-m-d', strtotime($end));
        $room = $request->post('room');
        $phone = $request->post('phone');
        $airlinkusername = $request->post('username');
        if (isset($name) OR $name != '') {
          // Check Member
          $Num_member = DB::table('member')
                          ->where('wifiusername', $airlinkusername)
                          ->where('wifipassword', $room)
                          ->count();
          $Formatdate =date('ym', strtotime(now()));
          $Data_member = DB::table('member')->where('code', 'like', 'H'.$Formatdate.'%')->orderBy('code', 'desc')->limit(1)->get();
          // Check Have Data
          if ($Data_member != '[]') {
             foreach ($Data_member as $key => $row) {
                 $FormatCode = substr($row->code,1);
                 $New_Number = strval($FormatCode)+1;
                 $New_Code = 'H'.$New_Number;
             }
          }else {
                 $New_Number = (strval($Formatdate)*1000)+1;
                 $New_Code = 'H'.$New_Number;
          }
          if ($Num_member == '0') {
            if ($room != 'undefined') {
              // Add To Memeber
              DB::table('member')->insert([
              'code' =>    $New_Code,
              'name' =>    $name,
              'start' =>   $restart,
              'expire' =>  $reend,
              'phone' =>   $phone,
              'type_detail' => 'Hotel',
              'type' => 'Hotel',
              'address' => 'ลูกค้าห้อง '.$room,
              'status' => 'Active',
              'daystop' => '0',
              'fullprice' => '0',
              'alldis' => '0',
              'remark' => '',
              'resultprice' => '0',
              'user_seting' => $username,
              'today' => $Today,
              'birthday' => '0000-00-00',
              'wifiusername' => $Re_account,
              'wifipassword' => $room,
              'wifidate' => $reend,
              ]);
              // Insert To DB Member_Detail
              DB::table('member_detail')->insert([
              'code' =>    $New_Code,
              'name' =>    $name,
              'start' =>   $restart,
              'expire' =>  $reend,
              'phone' =>   $phone,
              'type' => 'Hotel',
              'address' => 'ลูกค้าห้อง '.$room,
              'status' => 'Active',
              'daystop' => '0',
              'fullprice' => '0',
              'alldis' => '0',
              'remark' => '',
              'resultprice' => '0',
              'user_seting' => $username,
              'today' => $Today,
              'typestatus' => 'ลูกค้าโรงแรม',
              'type_commitment' => '0',
              'birthday' => '0000-00-00',
              ]);
              $Redirect_Code = $New_Code;
            }else{
              $Redirect_Code = 'Error';
            }
          }elseif ($Num_member == '1') {
            $Data_member = DB::table('member')
                            ->where('wifiusername', $airlinkusername)
                            ->where('wifipassword', $room)
                            ->get();
            foreach ($Data_member as $key => $row) {
              $Redirect_Code = $row->code;
            }
          }
        }else{
              $Redirect_Code = 'Error';
        }
        // Return Data
        $ResArray = ['Code' => $Redirect_Code];
        return \Response::json($ResArray);
    }

    public function Calculate_Day(Request $request)
    {
        if ($request->post('SelectVal') > 0) {
          // Data Type All
          $Data = DB::table('type')->where('type_id', $request->post('SelectVal'))->get();
          // Check Day Today
          if (empty($request->post('Daystart'))) {
            $renow = date("Y-m-d");
          }else{
            $formatstart = str_replace('/', '-', $request->post('Daystart'));
            $renow = date('Y-m-d', strtotime($formatstart));
          }
          // Generate_Code_User
          $New_Code  = $this->Generate_Code_User($renow);
          // Format Date Support
          foreach ($Data as $key => $row) {
              // Format
              $DateData = date_create($renow);
              // Modifly Day + Day
              date_modify($DateData, '+'.$row->type_day.' day');
              // Modifly Month + Month
              date_modify($DateData, '+'.$row->type_month.' month');
              // Modifly Years + Years
              date_modify($DateData, '+'.$row->type_year.' years');
              $ReFotmat = date_format($DateData, 'Y-m-d');
              // Price Type
              $PriceType = $row->type_price;
              // Type Name
              $TypeName  = $row->type_code;
              // Commitment
              $Commitment = $row->type_commitment;
          }
            $renow = date('d/m/Y', strtotime($renow));
            $ReFotmat = date('d/m/Y', strtotime($ReFotmat));
            // Return Data
            $ResArray = ['DateStart' => $renow,
                         'DateEnd' => $ReFotmat,
                         'TypeName' => $TypeName,
                         'PriceType' => $PriceType,
                         'Commitment' => $Commitment,
                         'New_Code' => $New_Code];
            return \Response::json($ResArray);
          }else{
            // Return Data
            $ResArray = ['DateStart' => '',
                         'DateEnd' => '',
                         'TypeName' => '',
                         'PriceType' => '0',
                         'Commitment' => '0'];
            return \Response::json($ResArray);
        }
    }

    public function StopMB(Request $request)
    {
        $Mumber = $request->post('Mumber');
        $Start = $request->post('Start');
        // Format
        $DateData = date_create($Start);
        // Modifly Day + Day
        date_modify($DateData, '+'.$Mumber.' day');
        $ReFotmat = date_format($DateData, 'Y-m-d');
        $formatstart = str_replace('-', '/', $ReFotmat);
        $End_StopMB = date('d/m/Y', strtotime($formatstart));
        // Show Json
        $array = array('End_StopMB' => $End_StopMB);
        $json = json_encode($array);
        echo $json;
    }

    public function Generate_Code_User($DateStart)
    {
          $Formatdate = date('ym', strtotime($DateStart));
          $users = DB::table('member')
                   ->select('code')
                   ->where( 'code', 'like', ''.$Formatdate.'%')
                   ->orderBy('code', 'desc')
                   ->limit(1)
                   ->get();
          // Check Have Data
          if ($users != '[]') {
             foreach ($users as $key => $row) {
                 $New_Code = strval($row->code)+1;
             }
          }else {
                 $New_Code = (strval($Formatdate)*1000)+1;
          }
          // Return Data
          return $New_Code;
    }

    public function Edit_member(Request $request)
    {
        date_default_timezone_set("Asia/Bangkok");  
        // Update birthday
        if ($request->post('birthday') != null) {
          $format_birthday = str_replace('/', '-', $request->post('birthday'));
          $Birthday = date('Y-m-d', strtotime($format_birthday));
          DB::table('member')
            ->where('code', $request->post('code'))
            ->update(['birthday' => $Birthday]);
          $status_birthday = 'success';
        }else{
          $status_birthday = 'error';
        }
        // Update Phone
        if ($request->post('phone') != null) {
          DB::table('member')
            ->where('code', $request->post('code'))
            ->update(['phone' => $request->post('phone')]);
          $status_phone = 'success';
        }else{
          $status_phone = 'error';
        }
        // Update address
        if ($request->post('address') != null) {
          DB::table('member')
            ->where('code', $request->post('code'))
            ->update(['address' => $request->post('address')]);          
          $status_address = 'success';
        }else{
          $status_address = 'error';
        }
      $ResArray = ['status_birthday' => $status_birthday, 'status_phone' => $status_phone, 'status_address' => $status_address, 'code' => $request->post('code')];
        return \Response::json($ResArray);
    }

    public function GenerateWiFi(Request $request)
    {
        date_default_timezone_set("Asia/Bangkok");
        // connect DB
        $Airlink = $this->Set_DB_Airlink();
        // Get Set Sting
        $username = $request->session()->get('Login.username');
        $Today = date("Y-m-d h:i:s");
        $TypeData = DB::table('type')->where('type_id', $request->post('Type_Add'))->get();
        $formatstart = str_replace('/', '-', $request->post('Start_Add'));
        $Start_POST = date('Y-m-d', strtotime($formatstart));
        $formatend = str_replace('/', '-', $request->post('End_Add'));
        $End_POST = date('Y-m-d', strtotime($formatend));
        $formatbirth = str_replace('/', '-', $request->post('Birthday_Add'));
        $Birth_POST = date('Y-m-d', strtotime($formatbirth));
        foreach ($TypeData as $key => $row) {
          // Get Type_code
          $type_data = $row->type_code;
          $type_commitment = $row->type_commitment;
          // Get StopMB
          if ($row->type_commitment == '1') {
              $StopMB = '90';
          }else{
              $StopMB = '0';
          }
          $type_pt_free = $row->type_pt_free;
        }
          // Format 
          if ($request->post('Birthday_Add') == '1970-01-01' OR $request->post('Birthday_Add') == '') {
                $Rebirthday = '0000-00-00';
          }else{
                $Rebirthday = $Birth_POST;
          }
          // Free Item
          if ($type_pt_free > '0') {
          DB::table('detail_table')->insert([
			    'code' => $request->post('Code_Add'),
			    'date_time' => $Today,
          'itemcode' => 'P',
			    'itemcodetype'  => 'P15',
			    'itemtype'  => 'T',
			    'itemname'  => 'โปรโมชั่น เทรนเนอร์ ฟรี',
			    'price'     => '0',
			    'sum'       => $type_pt_free,
          ]);
          $today = $Today;
          $date = date("Y-m-d");
          $code = $request->post('Code_Add');
          $itemcode = 'P';
          $itemtype = 'T';
          $itemname = 'โปรโมชั่น เทรนเนอร์ ฟรี';
          $itemprice= '0';
          $itemcodetype = 'P15';
          $itemsetnumber = $type_pt_free;
          // Insert Data Package Fake
          $fake_package = DB::table('fake_package')->insertGetId([
          'fake_code' => $code,
          'fake_datetime' => $today,
          'fake_itemcode' => $itemcode,
          'fake_typeitemcode' => $itemcodetype,
          'fake_typeitem' => $itemtype,
          'fake_itemname' => $itemname,
          'fake_price'    => $itemprice,
          'fake_sum'      => $itemsetnumber,
          'Status'        => 'BUY'
          ]);
          // Insert Data Package Main
          $package_detail_id = DB::table('package_detail')->insertGetId([
          'fake_code' => $code,
          'fake_datetime' => $today,
          'fake_itemcode' => $itemcode,
          'fake_typeitemcode' => $itemcodetype,
          'fake_typeitem' => $itemtype,
          'fake_itemname' => $itemname,
          'fake_price'    => $itemprice,
          'fake_sum'      => $itemsetnumber,
          ]);
          // Insert Package Main
          $idpackage = DB::table('main_package')->insertGetId([
          'main_package_id' => $package_detail_id,
          'Code' => $code,
          'date' => $date,
          'Status' => 'Active',
          'name_package' => $itemname,
          'total_sum' => $itemsetnumber,
          'have_sum' => $itemsetnumber]);
          // Update Main Id
          DB::table('fake_package')
              ->where('fake_code', $code)
              ->where('fake_package_id', $fake_package)
              ->update(['main_package_id' => $idpackage]);
          // Update Package Main
          DB::table('package_detail')
              ->where('fake_code', $code)
              ->where('package_id', $package_detail_id)
              ->update(['main_package_id' => $idpackage]);
          }
          if (empty($request->post('Discount_Add'))) {
              $alldis = "0";
          }else {
              $alldis = $request->post('Discount_Add');
          }
          // Insert To DB Member
          $ID_New_Code = DB::table('member')->insertGetId([
          'code' =>    $request->post('Code_Add'),
          'name' =>    $request->post('Name_Add'),
          'start' =>   $Start_POST,
          'expire' =>  $End_POST,
          'phone' =>   $request->post('Phone_Add'),
          'type_detail' => $type_data,
          'type' => $type_data,
          'address' => $request->post('Address_Add'),
          'status' => 'Active',
          'daystop' => $StopMB,
          'fullprice' => $request->post('Price_full_Add'),
          'alldis' => $alldis,
          'remark' => $request->post('Remark_Add'),
          'resultprice' => $request->post('Price_total_Add'),
          'user_seting' => $username,
          'today' => $Today,
          'birthday' => $Rebirthday,
          ]);
          // Update Id Card 
          $datanew = DB::table('member')->where('id', $ID_New_Code)->get();
          foreach ($datanew as $key => $row) {
            // ID Card
            if ($row->id_card == '') {
              DB::table('member')->where('id', $ID_New_Code)->update(['id_card' => $request->post('id_card_add')]);
            }
            // Card Start
            if ($row->card_start == '') {
              DB::table('member')->where('id', $ID_New_Code)->update(['card_start' => $request->post('card_start_add')]);
            }
            // Card End
            if ($row->card_end == '') {
              DB::table('member')->where('id', $ID_New_Code)->update(['card_end' => $request->post('card_end_add')]);
            }
            // Card Img
            if ($row->card_img == '') {
              DB::table('member')->where('id', $ID_New_Code)->update(['card_img' => $request->post('card_img_add')]);
            }
            // Card Img
            if ($row->gender == '') {
              DB::table('member')->where('id', $ID_New_Code)->update(['gender' => $request->post('gender')]);
            }
          }
          // Insert To DB Member_Detail
          $Member_detail_insert = DB::table('member_detail')->insertGetId([
          'code' =>    $request->post('Code_Add'),
          'name' =>    $request->post('Name_Add'),
          'start' =>   $Start_POST,
          'expire' =>  $End_POST,
          'phone' =>   $request->post('Phone_Add'),
          'type' => $type_data,
          'address' => $request->post('Address_Add'),
          'status' => 'Active',
          'daystop' => $StopMB,
          'fullprice' => $request->post('Price_full_Add'),
          'alldis' => $alldis,
          'remark' => $request->post('Remark_Add'),
          'resultprice' => $request->post('Price_total_Add'),
          'user_seting' => $username,
          'today' => $Today,
          'typestatus' => 'สมัครครั้งแรก',
          'type_commitment' => $type_commitment,
          'birthday' => $Rebirthday,
          ]);
          // Check Connect Status
          $Connect_Status = DB::table('connect')->where('connect_id', '1')->get();
          foreach ($Connect_Status as $key => $row) {
            $Data_Connect_Status = $row->connect_detail;
          }
          if ($Data_Connect_Status == '0') {
          // Set Data Proflie
          $Username_Code = $request->post('Code_Add');
          $Password = rand(1,100000);
          $Valid = date("Y-m-d",strtotime($End_POST))."T23:59:59";
          $Expired = strftime("%B %d %Y",strtotime($End_POST))." 23:59:59";
          $profile = $this->SetData($request->post('Name_Add'),$request->post('Phone_Add'));
          $Data_Billingplan = DB::connection('apimysql')->table("billingplan")->where('name', 'fitness')->get();
          foreach ($Data_Billingplan as $key => $row) {
             $Group = $row->groupname;
             $Ggroupname = $row->name;
             $Up = $row->bw_upload;
             $Down = $row->bw_download;
             $Re_url = $row->redirect_url;
             $Idle = $row->IdleTimeout;
             $Billplan = $row->name;
          }
          // Check Username In Airlink
          $Radusergroup = DB::connection('apimysql')->table("radusergroup")->where('username', $Username_Code)->count();
          // IF == NotHaveUser ANd  ELSE == HaveUser
          if ($Radusergroup > 0) {
              /* Demo Not Use Update
              // Update UserName radcheck Password
              DB::connection('apimysql')->table("radcheck")
              ->where('username', $Username_Code)
              ->where('attribute', 'Password')
              ->update(['value' => $Password]);
              // Update UserName radcheck Expiration
              DB::connection('apimysql')->table("radcheck")
              ->where('username', $Username_Code)
              ->where('attribute', 'Expiration')
              ->update(['value' => $Expired]);
              // Update UserName radreply UP
              DB::connection('apimysql')->table("radreply")
              ->where('username', $Username_Code)
              ->where('attribute', 'WISPr-Bandwidth-Max-Up')
              ->update(['value' => $Up]);
              // Update UserName radreply Down
              DB::connection('apimysql')->table("radreply")
              ->where('username', $Username_Code)
              ->where('attribute', 'WISPr-Bandwidth-Max-Down')
              ->update(['value' => $Down]);
              // Update UserName radreply Down
              DB::connection('apimysql')->table("radreply")
              ->where('username', $Username_Code)
              ->where('attribute', 'WISPr-Redirection-URL')
              ->update(['value' => $Re_url]);
              // Update UserName radusergroup
              DB::connection('apimysql')->table("radusergroup")
              ->where('username', $Username_Code)
              ->update(['groupname' => $Group, 'priority' => '1']);
              // Update UserName voucher
              DB::connection('apimysql')->table("voucher")
              ->where('username', $Username_Code)
              ->update(['password' => $Password, 'valid_until' => $Valid, 'profile' => $profile]);
              */
          }else{
              // Delete UserName radcheck
              DB::connection('apimysql')->table("radcheck")->where('username' , $Username_Code)->delete();
              // Insert UserName radcheck
              DB::connection('apimysql')->table("radcheck")->insert([
                  ['username' => $Username_Code, 'attribute' => 'Password', 'op' => ':=', 'value' => $Password],
                  ['username' => $Username_Code, 'attribute' => 'Expiration', 'op' => ':=', 'value' => $Expired],
                  ['username' => $Username_Code, 'attribute' => 'Auth-Type', 'op' => ':=', 'value' => 'Local']]);
              // Insert UserName radreply
              DB::connection('apimysql')->table("radreply")->insert([
                  ['username' => $Username_Code, 'attribute' => 'WISPr-Bandwidth-Max-Down', 'op' => ':=', 'value' => $Down],
                  ['username' => $Username_Code, 'attribute' => 'WISPr-Bandwidth-Max-Up', 'op' => ':=', 'value' => $Up],
                  ['username' => $Username_Code, 'attribute' => 'WISPr-Redirection-URL', 'op' => ':=', 'value' => $Re_url]]);
              // Insert UserName radusergroup
              DB::connection('apimysql')->table("radusergroup")->insert([
                  ['username' => $Username_Code, 'groupname' => $Group, 'priority' => '1']]);
              // Insert Username voucher
              DB::connection('apimysql')->table("voucher")->insert([ 
                  ['username' => $Username_Code,
                   'password' => $Password,
                   'billingplan' => $Billplan,
                   'created_by' => $username,
                   'IdleTimeout' => $Idle,
                   'valid_until' => $Valid,
                   'isprinted' => '0',
                   'profile' => $profile,
                   'encryption' => 'clear',
                   'money' => '0']]);
              //  Update UserName And Password To member
              DB::table('member')->where('id', $ID_New_Code)->update(['wifiusername' => $Username_Code,'wifipassword' => $Password, 'wifidate' => $End_POST]);
          }
        }
    }

    public function SetData($Name,$Phone)
    {
        // connect DB
        $Airlink = $this->Set_DB_Airlink();
        $Data_Billingplan = DB::connection('apimysql')->table("billingplan")->where('name', 'fitness')->get();
        foreach ($Data_Billingplan as $key => $row) {
           $billplan = $row->name;
        }
        // Function Has
        function _serialize($data){
            if(is_array($data)){foreach($data as $key=>$val){if(is_string($val)){$data[$key]=str_replace('','{{slash}}',$val);}}
            }else{if(is_string($data)){$data=str_replace('','{{slash}}',$data);}}
            return serialize($data);
        }
        function _unserialize($data){
          $data = @unserialize($data);
          if(is_array($data)){foreach($data as $key=>$val){if(is_string($val)){$data[$key]=str_replace('{{slash}}','',$val);}}return $data;}
          return (is_string($data)) ? str_replace('{{slash}}', '', $data) : $data;
        }
        // Clear Data
        $post_data = '';
        // Set Array
        $post_data = array();
        $user_data['firstname']     = $Name;
        $user_data['lastname']      = '';
        $user_data['surename']      = '';
        $user_data['gender']        = '';
        $user_data['billingplan']   = $billplan;
        $user_data['money']         = 0;
        $user_data['ip']            = '';
        $user_data['mac']           = '';
        $user_data['web']           = '';
        $user_data['personal_id']   = '';
        $user_data['phone']         = '';
        $user_data['email']         = '';
        $user_data['address1']      = '';
        $user_data['address2']      = '';
        $user_data['district']      = '';
        $user_data['amphur']        = '';
        $user_data['province']      = '';
        $user_data['note']          = '';
        $user_data['pic_upload']    = '';
        $profile1 = _serialize($user_data);
        $profile  = addslashes($profile1);
        return $profile;
    }

    public function Set_DB_Airlink()
    {
          $CheckAPI = DB::table('api_db')->where('key', 'Airlink')->get();
          foreach ($CheckAPI as $key => $row) {
            // MSSQL
            if ($row->driver == 'sqlsrv') {
              Config::set("database.connections.apisqlserv.driver" , "$row->driver");
              Config::set("database.connections.apisqlserv.host" , "$row->host");
              Config::set("database.connections.apisqlserv.database" , "$row->database");
              Config::set("database.connections.apisqlserv.username" , "$row->username");
              Config::set("database.connections.apisqlserv.password" , "$row->password");
            }elseif ($row->driver == 'mysql') {
              Config::set("database.connections.apimysql.driver" , "$row->driver");
              Config::set("database.connections.apimysql.host" , "$row->host");
              Config::set("database.connections.apimysql.database" , "$row->database");
              Config::set("database.connections.apimysql.username" , "$row->username");
              Config::set("database.connections.apimysql.password" , "$row->password");
            }
          }
          // Return
          return;
    }

    public function Set_DB_Epitome()
    {
          $CheckAPI = DB::table('api_db')->where('key', 'Epitome')->get();
          foreach ($CheckAPI as $key => $row) {
            // MSSQL
            if ($row->driver == 'sqlsrv') {
              Config::set("database.connections.apisqlserv.driver" , "$row->driver");
              Config::set("database.connections.apisqlserv.host" , "$row->host");
              Config::set("database.connections.apisqlserv.database" , "$row->database");
              Config::set("database.connections.apisqlserv.username" , "$row->username");
              Config::set("database.connections.apisqlserv.password" , "$row->password");
            }elseif ($row->driver == 'mysql') {
              Config::set("database.connections.apimysql.driver" , "$row->driver");
              Config::set("database.connections.apimysql.host" , "$row->host");
              Config::set("database.connections.apimysql.database" , "$row->database");
              Config::set("database.connections.apimysql.username" , "$row->username");
              Config::set("database.connections.apimysql.password" , "$row->password");
            }
          }
          // Return
          return;
    }

    public function Auto_Generate_wifi(Request $request)
    {
      date_default_timezone_set("Asia/Bangkok");
      // connect DB
      $Airlink = $this->Set_DB_Airlink();
      $Data_240 = DB::table('member')
                    ->select('*')
                    ->where('type_detail', '<>', 'Hotel')
                    ->where('status', 'Active')
                    ->where('wifipassword', '<>', '')
                    ->get();
      // ดึงข้อมูลของ Grop ใน Airlink
      $Data_Billingplan = DB::connection('apimysql')->table("billingplan")->where('name', 'fitness')->get();
      foreach ($Data_Billingplan as $key => $row) {
         $Group = $row->groupname;
         $Ggroupname = $row->name;
         $Up = $row->bw_upload;
         $Down = $row->bw_download;
         $Re_url = $row->redirect_url;
         $Idle = $row->IdleTimeout;
         $Billplan = $row->name;
      }
      $yes = 0;
      $no  = 0;
      foreach ($Data_240 as $key => $row) {
        $Username_Code = $row->wifiusername;
        $Password = $row->wifipassword;
        $Valid = date("Y-m-d",strtotime($row->expire))."T23:59:59";
        $Expired = strftime("%B %d %Y",strtotime($row->expire))." 23:59:59";
        // ดึงข้อมูลจาก Airlink จากการตรวจสอบ Code
        $Username_Airlink_H = DB::connection('apimysql')->table("voucher")->where('username', '=' , $row->code)->count();
        if ($Username_Airlink_H == '1') {
          // ถ้ามี Username ใน Airlink
          $yes++;
        }else{
          // ถ้าไม่มี Username ใน Ailink
          // Check Connect Status
          $Connect_Status = DB::table('connect')->where('connect_id', '1')->get();
          foreach ($Connect_Status as $key => $row) {
            $Data_Connect_Status = $row->connect_detail;
          }
          if ($Data_Connect_Status == '0') {
            // Delete UserName radcheck
            DB::connection('apimysql')->table("radcheck")
                ->where('username' , $Username_Code)->delete();
            // Insert UserName radcheck
            DB::connection('apimysql')->table("radcheck")->insert([
                ['username' => $Username_Code, 'attribute' => 'Password', 'op' => ':=', 'value' => $Password],
                ['username' => $Username_Code, 'attribute' => 'Expiration', 'op' => ':=', 'value' => $Expired],
                ['username' => $Username_Code, 'attribute' => 'Auth-Type', 'op' => ':=', 'value' => 'Local']]);
            // Insert UserName radreply
            DB::connection('apimysql')->table("radreply")->insert([
                ['username' => $Username_Code, 'attribute' => 'WISPr-Bandwidth-Max-Down', 'op' => ':=', 'value' => $Down],
                ['username' => $Username_Code, 'attribute' => 'WISPr-Bandwidth-Max-Up', 'op' => ':=', 'value' => $Up],
                ['username' => $Username_Code, 'attribute' => 'WISPr-Redirection-URL', 'op' => ':=', 'value' => $Re_url]]);
            // Insert UserName radusergroup
            DB::connection('apimysql')->table("radusergroup")->insert([
                ['username' => $Username_Code, 'groupname' => $Group, 'priority' => '1']]);
            // Delete UserName voucher
            DB::connection('apimysql')->table("voucher")
                ->where('username' , $Username_Code)->delete();
            // Insert Username voucher
            DB::connection('apimysql')->table("voucher")->insert([ 
                ['username' => $Username_Code,
                'password' => $Password,
                'billingplan' => $Billplan,
                'created_by' => 'AutoGen',
                'IdleTimeout' => $Idle,
                'valid_until' => $Valid,
                'isprinted' => '0',
                'profile' => 'a:1:{s:9:"firstname";s:18:"Auto_Generate_wifi";s:8:"lastname";s:0:"";}',
                'encryption' => 'clear',
                'money' => '0']]);
          }
          $no++;
        }
      }
      echo 'มีuser ทั้งหมด '. $yes; echo '<br>';
      echo 'ไม่มีuser ทั้งหมด '. $no;
    }

    public function Auto_Genpassword_airlink(Request $request)
    {
      date_default_timezone_set("Asia/Bangkok");
      // connect DB
      $Airlink = $this->Set_DB_Airlink();
      $Connect_Status = DB::table('connect')->where('connect_id', '1')->value('connect_detail');
      $Data_240 = DB::table('member')
                    ->select('*')
                    ->where('type_detail', '<>', 'Hotel')
                    ->where('status', 'Active')
                    ->where('wifipassword', '<>', '')
                    ->get();
      if ($Connect_Status == '0') {
        foreach ($Data_240 as $key => $row) {
            $code_airlink_pass = DB::connection('apimysql')->table("voucher")->where('username', $row->wifiusername)->value('password');
            if ($code_airlink_pass == '') {
                $Valid = date("Y-m-d",strtotime($row->expire))."T23:59:59";
                $Expired = strftime("%B %d %Y",strtotime($row->expire))." 23:59:59";
                echo 'Code '. $row->wifiusername .' | ไม่มี User Airlink <br>';
            }else {
                if ($code_airlink_pass != $row->wifipassword) {
                    DB::table('member')->where('code', $row->wifiusername)
                                       ->update(['wifipassword' => $code_airlink_pass]);
                    echo $row->wifiusername.' | แก้ไขแล้ว <br>';
                }
            }
        }
      }
    }

    public function Get_Table_document(Request $request)
    {
      date_default_timezone_set("Asia/Bangkok");  
      $Data = DB::table('member')->where('code', $request->post('Code'))->get();
      foreach ($Data as $key => $row) {
        $Data = '';
        if ($row->document_img != '') {
          $Data .= "<tr class='text-center'>";
          $Data .= "<td>$row->document_img</td>";
          $Data .= "<td><button class='btn btn-sm btn-primary'>ข้อมูล รูปภาพ</button></td>";
          $Data .= "</td>";
          $Data .= "</tr>";
        }
        if ($row->document_file != '') {
          $Data .= "<tr class='text-center'>";
          $Data .= "<td>$row->document_file</td>";
          $Data .= "<td><button class='btn btn-sm btn-primary'>ข้อมูล ไฟล์</button></td>";
          $Data .= "</td>";
          $Data .= "</tr>";
        }
      }
        // Show Json
        $array = array('Table' => $Data);

        return response()->json($array);
    }


}