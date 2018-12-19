<?php
namespace App\Http\Controllers;

use App;
use Config;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Input;
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
        $users = DB::table('member')
                  ->select('*')
                  ->orderBy('start', 'desc');
        return Datatables::of($users)
        ->filter(function ($query) use ($request) {
            if ($request->has('searchingcode')) {
                $query->where('code', 'like', "%{$request->get('searchingcode')}%");
            }
            if ($request->has('searchingselect')) {
                if ($request->get('searchingselect') == 'Active' OR $request->get('searchingselect') == 'Expired') {
                  $query->where('status', 'like', "%{$request->get('searchingselect')}%");
                }else{
                  // Status All
                }
            }
            if ($request->get('search')['value']) {
                $query->whereRaw("CONCAT(code,'-',name,'-',phone) like ?", ["%{$request->get('search')['value']}%"]);
            }
        })
        ->setRowClass(function ($users) {
                if ($users->status == 'Active') {
                    $FormatToDay = date('d-m');
                    $FormatBirthday = date('d-m', strtotime($users->birthday));
                    if ($users->status == 'Active' AND $FormatBirthday == $FormatToDay) {
                    $reclass = "devcon-badge";
                    }else{
                    $reclass = "bg-info";
                    }
                }elseif ($users->status == 'Expired') {
                    $reclass = "bg-danger";
                }else{
                    $reclass = "";
                }
            return $reclass;
        })
        ->editColumn('address', '{!! str_limit($address, 50) !!}')
        ->editColumn('start', function($users) {
            return date('d-m-Y', strtotime($users->start));
        })
        ->editColumn('expire', function($users) {
            return date('d-m-Y', strtotime($users->expire));
        })
        ->editColumn('birthday', function($users) {
            if ($users->birthday == '0000-00-00' OR $users->birthday == '1970-01-01') {
              $rebirthday = "-";
            }else{
              $rebirthday = date('d-m-Y', strtotime($users->birthday));
            }
            return $rebirthday;
        })
        ->addColumn('action', function ($users) {
                $Data  = '<button class="btn btn-sm btn-success" id="'.$users->code.'" onclick="ViewData(this)"><i class="fas fa-search"></i>View</button> ';
                return $Data;
        })
        ->make(true);
    }

    public function Model_code_viewdata(Request $request)
    {
      $users = DB::table('member_detail')
                ->select('*')
                ->where('code', '=', $request->post('model_code_viewdata'))
                ->orderBy('start', 'desc');
      return Datatables::of($users)
      ->editColumn('start', function($users) {
          return date('d-m-Y', strtotime($users->start));
      })
      ->editColumn('expire', function($users) {
          return date('d-m-Y', strtotime($users->expire));
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
        $Datatype = DB::table('type')->get();
        foreach ($Data as $key => $row) {
        $View  = "<div class='row'>";
        $View .= "<div class='col-md-9'>";
        $View .= "<div class='card'>
        <div class='card-header'>
            <h5 class='card-title'>ข้อมูลทั่วไปของคุณ: $row->name</h5>
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
        if ($row->Img != '') {
        $View .= "<img style='width: 200px; height: 200px;' src='./img/$row->Img' alt='Img' class='img-thumbnail'>";
        }else{
        $View .= "<img style='width: 200px; height: 200px;' src='./img/default.svg' alt='Img' class='img-thumbnail'>";
        }
        $View .= "<p></p>
                  <div class='upload-btn-wrapper'>
                  <button class='btn btn-sm btn-primary'>อัพโหลด รูปภาพ</button>
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
                            <input type='text' style='margin-top:5px;' class='form-control form-control-sm' id='remember_reconnent_stopmb' disabled>
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
      $View .=  "     </th>
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
      $View .=  "     </th>
                    </tr>
                    <tr>
                      <td align='center'><b>Password:</b></td>
                      <th>";
                      if ($row->wifipassword != '') {
                        $View .=  "<input type='text' class='form-control form-control-sm' disabled value='$row->wifipassword'>";
                      }else{
                        $View .=  "<input type='text' class='form-control form-control-sm' disabled value='ยังไม่มีข้อมูล Password'>";
                      }
      $View .=  "     </th>
                      <th></th>
                      <th></th>
                    </tr>
                  </table>
                  </div>";

        $View .=  "<div class='tab-pane fade' id='nav-contact' role='tabpanel' aria-labelledby='nav-contact-tab'>
                  <table class='table table-sm dt-responsive nowrap  row-border table-bordered table-hover TableDisplay' cellspacing='0' cellpadding='0' id='TableDisplayDetail'>
                      <thead>
                          <tr align='center' class='bg-primary'>
                              <th>ชื่อลูกค้า</th>
                              <th>วันที่เริ่มต้น</th>
                              <th>วันที่สิ้นสุด</th>
                              <th>สถานะ</th>
                              <th>ราคาเต็ม</th>
                              <th>ส่วนลด</th>
                              <th>ราคารวม</th>
                              <th>สถานะ</th>
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
                              <th>สถานะ</th>
                          </tr>
                      </tfoot>
                  </table>
                  </div>";
        $View .=  "<div class='tab-pane fade' id='nav-editprofile' role='tabpanel' aria-labelledby='nav-editprofile-tab'>
                  <table class='table table-sm table-bordered' width='100%'>
                    <tr>
                     <td align='center'><b>แก้ไขชื่อ ลูกค้า</b></td>
                     <td><input type='text' class='form-control form-control-sm' id='edit_name_input' placeholder='เปลี่ยนชื่อลูกค้า'></td>
                     <td align='center'><b>แก้ไขเบอร์ ลูกค้า</b></td>
                     <td><input type='text' class='form-control form-control-sm' id='edit_phone_input' placeholder='เปลี่ยนเบอร์โทร'></td>
                    </tr>
                    <tr>
                    <td align='center'><b>แก้ไข ที่อยู่</b></td>
                    <td colspan='3'>
                    <textarea class='form-control' rows='2' placeholder='เปลี่ยนที่อยู่ลูกค้า'></textarea>
                    </td>
                    </tr>
                  </table>
                  <div align='center'><button class='btn btn-success btn-sm'>อัพเดต</button></div>
                  </div>";

        $View .= "</div>";
        $View .= "</div>";
        $View .= "</div>";
        }
        // Show Json
        $array = array('Table' => $View);
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
            $Modidy_Date = $expire_member;
        }else{
            $Modidy_Date = $select_date;
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
        $formatstart = date('d/m/Y',strtotime($start_member));
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
             unlink(public_path("img/$row->Img"));
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

    public static function GetTypeData()
    {
        $TypeData = DB::table('type')->get();
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
        // connect DB
        $Epitome = $this->Set_DB_Epitome();
        $DataEpitome = DB::connection('apisqlserv')->table("guest")
                       ->where('room', 'like' ,$request->post('Text_Code').'%')
                       ->where('status', '=' , 'I')
                       ->orderBy('id', 'desc')
                       ->limit(20)
                       ->get();
        // Table DATA
        $Table  = "<br><table class='table table-sm' style='font-size: 13px;'>";
        $Table .= "<thead><tr align='center'><th>ห้องลูกค้า</th><th>ชื่อลูกค้า</th><th>เข้าพักถึงวันที่</th><th>สัญญาติ</th></tr></thead>";
        $Table .= "<tbody>";
        foreach ($DataEpitome as $key => $row) {
          $Datedeparture = date_create($row->departure);
          $Redeparture = date_format($Datedeparture, 'd-m-Y');
          $Table .= "<tr align='center'>";
          $Table .= "<td><a href='#'><span onclick='Send_To_Register(this);' class='badge badge-pill badge-primary' account='$row->account' name='$row->name' start='$row->arrival' end='$row->departure' room='$row->room' phone='$row->phone' company='$row->company'>$row->room</span></a></td>";
          $Table .= "<td>$row->name</td>";
          $Table .= "<td>$Redeparture</td>";
          $Table .= "<td>$row->geo</td>";
          $Table .= "</tr>";
        }
        $Table .= "</tbody>";
        $Table .= "</table>";

       $ResArray = ['Table' => $Table];
       return \Response::json($ResArray);
    }

    public function SendToRegister(Request $request)
    {
        $username = $request->session()->get('Login.username');
        $Today = date("Y-m-d h:i:s");
        $Re_account = substr($request->post('account'),6);
        $name = $request->post('name');
        $start = $request->post('start');
        $restart = date('Y-m-d', strtotime($start));
        $end = $request->post('end');
        $reend = date('Y-m-d', strtotime($end));
        $room = $request->post('room');
        $phone = $request->post('phone');
        $company = $request->post('company');
        // Check Member
        $Num_member = DB::table('member')->where([
                        ['name', '=', $name],
                        ['start', '=', $start],
                        ['expire', '=', $reend],
                      ])->count();
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
          // Add To Memeber
          DB::table('member')->insert([
          'code' =>    $New_Code,
          'name' =>    $name,
          'start' =>   $restart,
          'expire' =>  $reend,
          'phone' =>   $phone,
          'type_detail' => 'Hotel',
          'type' => 'Hotel',
          'address' => 'ลูกค้าห้อง '.$room.' จาก '.$company,
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
          'address' => 'ลูกค้าห้อง '.$room.' จาก '.$company,
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
        }elseif ($Num_member == '1') {
          $Data_member = DB::table('member')->where([['name', '=', $name],['start', '=', $start],['expire', '=', $reend]])->get();
          foreach ($Data_member as $key => $row) {
            $Redirect_Code = $row->code;
          }
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
            $renow = $request->post('Daystart');
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

    public function Generate_Code_User($DateStart)
    {
          $Formatdate =date('ym', strtotime($DateStart));
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

    public function GenerateWiFi(Request $request)
    {
        // connect DB
        $Airlink = $this->Set_DB_Airlink();
        // Get Set Sting
        $username = $request->session()->get('Login.username');
        $Today = date("Y-m-d h:i:s");
        $TypeData = DB::table('type')->where('type_id', $request->post('Type_Add'))->get();
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
        }
        if ($request->post('Birthday_Add') == '1970-01-01') {
              $Rebirthday = '0000-00-00';
        }else{
              $Rebirthday = $request->post('Birthday_Add');
        }
          // Insert To DB Member
          $ID_New_Code = DB::table('member')->insertGetId([
          'code' =>    $request->post('Code_Add'),
          'name' =>    $request->post('Name_Add'),
          'start' =>   $request->post('Start_Add'),
          'expire' =>  $request->post('End_Add'),
          'phone' =>   $request->post('Phone_Add'),
          'type_detail' => $type_data,
          'type' => $type_data,
          'address' => $request->post('Address_Add'),
          'status' => 'Active',
          'daystop' => $StopMB,
          'fullprice' => $request->post('Price_full_Add'),
          'alldis' => $request->post('Discount_Add'),
          'remark' => $request->post('Remark_Add'),
          'resultprice' => $request->post('Price_total_Add'),
          'user_seting' => $username,
          'today' => $Today,
          'birthday' => $Rebirthday,
          ]);
          // Insert To DB Member_Detail
          $Member_detail_insert = DB::table('member_detail')->insertGetId([
          'code' =>    $request->post('Code_Add'),
          'name' =>    $request->post('Name_Add'),
          'start' =>   $request->post('Start_Add'),
          'expire' =>  $request->post('End_Add'),
          'phone' =>   $request->post('Phone_Add'),
          'type' => $type_data,
          'address' => $request->post('Address_Add'),
          'status' => 'Active',
          'daystop' => $StopMB,
          'fullprice' => $request->post('Price_full_Add'),
          'alldis' => $request->post('Discount_Add'),
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
          $Username_Code = 'T'.$request->post('Code_Add');
          $Password = rand(1,100000);
          $Valid = date("Y-m-d",strtotime($request->post('End_Add')))."T23:59:59";
          $Expired = strftime("%B %d %Y",strtotime($request->post('End_Add')))." 23:59:59";
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
              DB::table('member')->where('id', $ID_New_Code)->update(['wifiusername' => $Username_Code,'wifipassword' => $Password, 'wifidate' => $request->post('End_Add')]);
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
            if(is_array($data)){foreach($data as $key=>$val){if(is_string($val)){$data[$key]=str_replace('\\','{{slash}}',$val);}}
            }else{if(is_string($data)){$data=str_replace('\\','{{slash}}',$data);}}
            return serialize($data);
        }
        // Set Array
        $post_data=array();
        $post_data['firstname']     = $Name;
        $post_data['lastname']      = '';
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


}
