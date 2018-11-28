<?php

namespace App\Http\Controllers;

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
                    $reclass = "bg-info";
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
                ->orderBy('start', 'asc');
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
                  1111
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
                              <th>ตัวช่วย</th>
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
                              <th>ตัวช่วย</th>
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
        print_r($request->post());
    }


}
