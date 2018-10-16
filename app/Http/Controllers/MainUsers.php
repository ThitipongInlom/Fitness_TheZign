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
                  <tbody><tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Reason</th>
                  </tr>
                  <tr>
                    <td>183</td>
                    <td>John Doe</td>
                    <td>11-7-2014</td>
                    <td><span class='tag tag-success'>Approved</span></td>
                    <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                  </tr>
                  <tr>
                    <td>219</td>
                    <td>Alexander Pierce</td>
                    <td>11-7-2014</td>
                    <td><span class='tag tag-warning'>Pending</span></td>
                    <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                  </tr>
                </tbody></table>
              </div>
            </div>";
        $View .= "</div>";
        $View .= "<div class='col-md-3'>";
        $View .= "<img src='./img/default.svg' alt='Img' class='img-thumbnail'>";
        $View .= "</div>";
        // End Row
        $View .= "</div><hr>";
        }
        // Show Json
        $array = array('Table' => $View);
        $json = json_encode($array);
        echo $json;
    }
}
