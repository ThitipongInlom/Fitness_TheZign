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
                    <th align='center' colspan='2'>$row->start</th>
                    <th align='left'>วันที่สิ้นสุด:</th>
                    <th align='center' colspan='2'>$row->expire</th>
                  </tr>
                  <tr>
                    <th align='left'>วันเกิด:</th>
                    <th align='center' colspan='2'>$row->birthday</th>
                    <th align='left'>เบอร์โทร::</th>
                    <th align='center' colspan='2'>$row->phone</th>
                  </tr>
                  <tr>
                    <th align='left'>ที่อยู่:</th>
                    <th colspan='5'><textarea class='form-control' placeholder='ที่อยู่ของลูกค้า' rows='2'>$row->address</textarea></th>
                  </tr>
                </tbody>
            </table>
          </div>
        </div>";
        $View .= "</div>";
        $View .= "<div class='col-md-3'>";
        if ($row->Img != '') {
        $View .= "<img src='./img/$row->Img' alt='Img' class='img-thumbnail'>";
        }else{
        $View .= "<img src='./img/default.svg' alt='Img' class='img-thumbnail'>";
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
                  </div>
                  </nav>

                  <div class="tab-content" id="nav-tabContent">
                  <div class="tab-pane fade show active" id="nav-extend" role="tabpanel" aria-labelledby="nav-extend-tab">1111</div>
                  <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">2222</div>
                  <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">3333</div>
                  </div>';
        $View .= "</div>";
        $View .= "</div>";
        }
        // Show Json
        $array = array('Table' => $View);
        $json = json_encode($array);
        echo $json;
    }
}
