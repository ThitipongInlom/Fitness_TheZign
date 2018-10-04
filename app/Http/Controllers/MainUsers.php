<?php

namespace App\Http\Controllers;

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

    public function Data()
    {
        $users = DB::table('member')
                  ->select('*')
                  ->orderBy('start', 'desc');
        return Datatables::of($users)
        ->addColumn('action', function ($users) {
                $Data  = '<a href="#'.$users->code.'" class="btn btn-sm btn-primary">View</a> ';
                $Data .= '<a href="#'.$users->code.'" class="btn btn-sm btn-success">Edit</a>';
                return $Data;
        })
        ->make(true);
    }
}
