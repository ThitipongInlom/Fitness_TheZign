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

class Closeday extends Controller
{
    public function Index_Closeday()
    {
        $Today = $this->Getdate_closeday();
        $Data = $this->Get_sumuseruse($Today,'Lock1');
        print_r($Data); echo 'ผ้า -> '; echo $this->Get_fabricbig($Today);
        echo '<br>';
        echo $Today;
    }

    public function Getdate_closeday()
    {
        $Data = date("Y-m-d");
        $Datecloseday = date_create($Data);
        //date_modify($Datecloseday, '-1 day');
        return date_format($Datecloseday, 'Y-m-d');
    }

    public function Gettotal_guestuse($Today)
    {
        $Data = DB::table('main_table')
                ->where('date', $Today)
                ->count();
        return $Data;
    }

    public function Get_sumuseruse($Today,$Lock)
    {
        $Member = DB::table('main_table')
                ->join('detail_table', 'main_table.ID', '=', 'detail_table.main_id')
                ->join('member', 'main_table.Code', '=', 'member.code')
                ->groupBy('main_table.Guset_in')
                ->orderBy('main_table.Guset_in', 'ASC')
                ->where('main_table.Status', '=', 'OUT')
                ->where('date', $Today)
                ->get();
        // @ Get Member_count -> Lock1
        $member_count = 0;
        // @ Get K_bank -> Lock2
        $k_bank = 0;
        // @ Get Hotel_count -> Lock3
        $hotel_count = 0;
        // @ Get Gusetpass -> Lock4
        $gusetpass = 0;
        foreach ($Member as $key => $row) {
            if ($row->type == 'Hotel') {
                $hotel_count++;
            }elseif ($row->type == '1DM') {
                $gusetpass++;
            }elseif ($row->type == '1D-Kbank') {
                $k_bank++;
            }else{
                $member_count++;
            }
        }
        // @ Return Data
        switch ($Lock) {
            case 'Lock1':
                return $member_count;
            break;
            case 'Lock2':
                return $k_bank;
            break;
            case 'Lock3':
                return $hotel_count;
            break;
            case 'Lock4':
                return $gusetpass;
            break;           
        }
    }

    public function Get_fabricbig($Today)
    {
        $Fabricbig = DB::table('main_table')
            ->select('*', DB::raw('SUM(detail_table.sum) as total_sum'))
            ->join('detail_table', 'main_table.ID', '=', 'detail_table.main_id')
            ->where('detail_table.itemcode', '=', 'L3')
            ->where('date', $Today)
            ->get();
        foreach ($Fabricbig as $key => $row) {
            $Fabricbig = $row->total_sum;
        }
        return $Fabricbig;    
    }

    public function Get_fabricsamll($Today)
    {
        $Fabricbig = DB::table('main_table')
            ->select('*', DB::raw('SUM(detail_table.sum) as total_sum'))
            ->join('detail_table', 'main_table.ID', '=', 'detail_table.main_id')
            ->where('detail_table.itemcode', '=', 'L1')
            ->where('date', $Today)
            ->get();
        foreach ($Fabricbig as $key => $row) {
            $Fabricbig = $row->total_sum;
        }
        return $Fabricbig;  
    }

    public function Get_cloak()
    {
        $Fabricbig = DB::table('main_table')
            ->select('*', DB::raw('SUM(detail_table.sum) as total_sum'))
            ->join('detail_table', 'main_table.ID', '=', 'detail_table.main_id')
            ->where('detail_table.itemcode', '=', 'L2')
            ->where('date', $Today)
            ->get();
        foreach ($Fabricbig as $key => $row) {
            $Fabricbig = $row->total_sum;
        }
        return $Fabricbig; 
    }

    public function Get_newmember()
    {
        # code...
    }

}
