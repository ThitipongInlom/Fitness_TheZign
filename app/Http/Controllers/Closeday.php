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
        $Check_indatabase = $this->Check_Dataindatabase($Today);
        // เช็ค ว่ามีข้อมูล ใน Database หรือไม่ ถ้าไม่มีให้ Insert ข้อมูลเข้าไป
        if ($Check_indatabase == '0') {
            DB::table('closeday')->insert([
                'date_report' => $Today, 
                'total_guestuse' => $this->Gettotal_guestuse($Today),
                'member_in' => $this->Get_sumuseruse($Today,'Lock1'),
                'hotel_in' => $this->Get_sumuseruse($Today,'Lock2'),
                'kbank_in' => $this->Get_sumuseruse($Today,'Lock3'),
                'guestest_in' => $this->Get_sumuseruse($Today,'Lock4'),
                'fabricbig' => $this->Get_fabricbig($Today),
                'fabricsamll' => $this->Get_fabricsamll($Today),
                'cloak' => $this->Get_cloak($Today),
                'newmember' => $this->Get_newmember($Today),
                'reconnentmember' => $this->Get_reconnentmember($Today),
                'newhotel' => $this->Get_newhotel($Today),
                'reconnenthotel' => $this->Get_reconnenthotel($Today),
                'classtotal' => $this->Get_classtotal($Today),
                'thaiboxing' => $this->Get_countclass($Today,'C1'),
                'circuit' => $this->Get_countclass($Today,'C2'),
                'fitball' => $this->Get_countclass($Today,'C3'),
                'powerflghting' => $this->Get_countclass($Today,'C4'),
                'aerobicbignner' => $this->Get_countclass($Today,'C5'),
                'yoga' => $this->Get_countclass($Today,'C6'),
                'bodychallenge' => $this->Get_countclass($Today,'C7'),
                'suep' => $this->Get_countclass($Today,'C8'),
                'sixpack' => $this->Get_countclass($Today,'C9'),
                'stepbiginner' => $this->Get_countclass($Today,'C10'),
                'swimming' => $this->Get_countclass($Today,'C11'),
                'powerstrighting' => $this->Get_countclass($Today,'C12'),
                'totalsell' => $this->Get_totalsell($Today),
                'water' => $this->Get_water($Today,'Sum'),
                'mwater' => $this->Get_water($Today,'Sell'),
                'protein' => $this->Get_protein($Today,'Sum'),
                'mprotein' => $this->Get_protein($Today,'Sell'),
                'sellpackagetotal' => $this->Get_sellpackagetotal($Today),
                'thaiboxing1hrs' => $this->Get_sumpackage($Today,'P1','Sell'),
                'thaiboxing1hrs_sum' => $this->get_sumpackage($Today,'P1','Sum'),
                'thaiboxing10hrs' => $this->get_sumpackage($Today,'P2','Sell'),
                'thaiboxing10hrs_sum' => $this->get_sumpackage($Today,'P2','Sum'),
                'training1hrs' => $this->get_sumpackage($Today,'P3','Sell'),
                'training1hrs' => $this->get_sumpackage($Today,'P3','Sum'),
                'buddy_training1hrs' => $this->get_sumpackage($Today,'P4','Sell'),
                'buddy_training1hrs_sum' => $this->get_sumpackage($Today,'P4','Sum'),
                'buddy_training20hrs' => $this->get_sumpackage($Today,'P5','Sell'),
                'buddy_training20hrs_sum' => $this->get_sumpackage($Today,'P5','Sum'),
                'gym15hrs' => $this->get_sumpackage($Today,'P6','Sell'),
                'gym15hrs_sum' => $this->get_sumpackage($Today,'P6','Sum'),
                'gym25hrs' => $this->get_sumpackage($Today,'P7','Sell'),
                'gym25hrs_sum' => $this->get_sumpackage($Today,'P7','Sum'),
                'gym35hrs' => $this->get_sumpackage($Today,'P8','Sell'),
                'gym35hrs_sum' => $this->get_sumpackage($Today,'P8','Sum'),
                'gym45hrs' => $this->get_sumpackage($Today,'P9','Sell'),
                'gym45hrs_sum' => $this->get_sumpackage($Today,'P9','Sum'),
                'swimming1hrs' => $this->get_sumpackage($Today,'P10','Sell'),
                'swimming1hrs_sum' => $this->get_sumpackage($Today,'P10','Sum'),
                'swimming13hrs' => $this->get_sumpackage($Today,'P11','Sell'),
                'swimming13hrs_sum' => $this->get_sumpackage($Today,'P11','Sum'),
                'swimming20hrs' => $this->get_sumpackage($Today,'P12','Sell'),
                'swimming20hrs_sum' => $this->get_sumpackage($Today,'P12','Sum'),
                'swimming27hrs' => $this->get_sumpackage($Today,'P13','Sell'),
                'swimming27hrs_sum' => $this->get_sumpackage($Today,'P13','Sell'),
                'sumtotal' => $this->Get_sumtotal($Today),
                'newmember_pricemax' => $this->Get_newmember_pricemax($Today),
                'newmember_pricediscount' => $this->Get_newmember_pricediscount($Today),
                'newmember_pricetotal' => $this->Get_newmember_pricetotal($Today),
                'newmember_stopsum' => $this->Get_newmember_stopsum($Today),
                'newmember_stopprice' => $this->Get_newmember_stopprice($Today),
            ]);
        }      
    }

    public function Check_Dataindatabase($Today)
    {
        $Data = DB::table('closeday')->where('date_report', $Today)->count();
        return $Data;
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
                ->whereDate('date', $Today)
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
                ->whereDate('date', $Today)
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
                   ->whereDate('date', $Today)
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
                   ->whereDate('date', $Today)
                   ->get();
        foreach ($Fabricbig as $key => $row) {
            $Fabricbig = $row->total_sum;
        }
        return $Fabricbig;  
    }

    public function Get_cloak($Today)
    {
        $Fabricbig = DB::table('main_table')
                   ->select('*', DB::raw('SUM(detail_table.sum) as total_sum'))
                   ->join('detail_table', 'main_table.ID', '=', 'detail_table.main_id')
                   ->where('detail_table.itemcode', '=', 'L2')
                   ->whereDate('date', $Today)
                   ->get();
        foreach ($Fabricbig as $key => $row) {
            $Fabricbig = $row->total_sum;
        }
        return $Fabricbig; 
    }

    public function Get_newmember($Today)
    {
        $Newmember = DB::table('member_detail')
                    ->select('*')
                    ->whereDate('today', $Today)
                    ->where('type', '<>', 'Hotel')
                    ->where('typestatus', 'สมัครครั้งแรก')
                    ->count();
        return $Newmember;
    }

    public function Get_reconnentmember($Today)
    {
        $Reconnentmember = DB::table('member_detail')
                    ->select('*')
                    ->whereDate('today', $Today)
                    ->where('type', '<>', '1D-Kbank')
                    ->where('type', '<>', 'Hotel')
                    ->where('type', '<>', '1DM')
                    ->where('typestatus', 'ต่ออายุการใช้งาน')
                    ->count();
        return $Reconnentmember;
    }

    public function Get_newhotel($Today)
    {
        $Newhotel = DB::table('member_detail')
                    ->select('*')
                    ->whereDate('today', $Today)
                    ->where('type', 'Hotel')
                    ->where('typestatus', 'ลูกค้าโรงแรม')
                    ->count();
        return $Newhotel;
    }

    public function Get_reconnenthotel($Today)
    {
        $Reconnenthotel = DB::table('member_detail')
                    ->select('*')
                    ->whereDate('today', $Today)
                    ->where('type', 'Hotel')
                    ->where('typestatus', 'ต่ออายุการใช้งาน')
                    ->count();
        return $Reconnenthotel;
    }

    public function Get_classtotal($Today)
    {
        $Classtotal = DB::table('main_table')
                   ->select('*', DB::raw('SUM(detail_table.sum) as total_sum'))
                   ->join('detail_table', 'main_table.ID', '=', 'detail_table.main_id')
                   ->where('detail_table.itemtype', '=', 'C')
                   ->whereDate('date', $Today)
                   ->count();
        return $Classtotal;
    }

    public function Get_countclass($Today,$ClassID)
    {
        $Classdata = DB::table('main_table')
                   ->select('*', DB::raw('SUM(detail_table.sum) as total_sum'))
                   ->join('detail_table', 'main_table.ID', '=', 'detail_table.main_id')
                   ->where('detail_table.itemcode', '=', $ClassID)
                   ->whereDate('date', $Today)
                   ->count();
        return $Classdata;
    }

    public function Get_totalsell($Today)
    {
        $Totalsell = DB::table('main_table')
                   ->select('*', DB::raw('SUM(detail_table.price) as totalsell'))
                   ->join('detail_table', 'main_table.ID', '=', 'detail_table.main_id')
                   ->where('detail_table.itemtype', 'L')
                   ->whereDate('date', $Today)
                   ->get();
        foreach ($Totalsell as $key => $row) {
            $Totalsell = $row->totalsell;
        }
        return $Totalsell;   
    }

    public function Get_water($Today,$type)
    {
        $Water = DB::table('main_table')
                   ->select('*', DB::raw('SUM(detail_table.price) as sell'),DB::raw('SUM(detail_table.sum) as sum'))
                   ->join('detail_table', 'main_table.ID', '=', 'detail_table.main_id')
                   ->where('detail_table.itemcode', 'L4')
                   ->whereDate('date', $Today)
                   ->get();
        foreach ($Water as $key => $row) {
            $watersell = $row->sell;
            $watersum = $row->sum;
        }
        // @ Type Return Sell || Sum
        switch ($type) {
            case 'Sell':
                return $watersell; 
            break;
            case 'Sum':
                return $watersum; 
            break;           
        }
    }

    public function Get_protein($Today,$type)
    {
        $Proteinr = DB::table('main_table')
                   ->select('*', DB::raw('SUM(detail_table.price) as sell'),DB::raw('SUM(detail_table.sum) as sum'))
                   ->join('detail_table', 'main_table.ID', '=', 'detail_table.main_id')
                   ->where('detail_table.itemcode', 'L5')
                   ->whereDate('date', $Today)
                   ->get();
        foreach ($Proteinr as $key => $row) {
            $proteinsell = $row->sell;
            $proteinsum = $row->sum;
        }
        // @ Type Return Sell || Sum
        switch ($type) {
            case 'Sell':
                return $proteinsell; 
            break;
            case 'Sum':
                return $proteinsum; 
            break;           
        }
    } 
    
    public function Get_sellpackagetotal($Today)
    {
        $Sellpackagetotal = DB::table('main_package')
                            ->select(DB::raw('SUM(package_detail.fake_price) as sellpackagetotal'))
                            ->join('package_detail', 'main_package.id', '=', 'package_detail.main_package_id')
                            ->whereDate('date', $Today)
                            ->get();
        foreach ($Sellpackagetotal as $key => $row) {
            $Sellpackagetotal = $row->sellpackagetotal;
        }
        return $Sellpackagetotal;
    }

    public function Get_sumpackage($Today,$type,$Lock)
    {
        $Datapackage = DB::table('main_package')
                        ->select(DB::raw('SUM(package_detail.fake_price) as sellpackagetotal'),DB::raw('COUNT(package_detail.fake_price) as totalpackage'))
                        ->join('package_detail', 'main_package.id', '=', 'package_detail.main_package_id')
                        ->where('fake_itemcode', $type)
                        ->whereDate('date', $Today)
                        ->get();
        foreach ($Datapackage as $key => $row) {
            $Sellpackagetotal = $row->sellpackagetotal;
            $Totalpackage = $row->totalpackage;
        }
        switch ($Lock) {
            case 'Sell':
                return $Sellpackagetotal;
            break;
            case 'Sum':
                return $Totalpackage;
            break;           
        }
    }

    public function Get_sumtotal($Today)
    {
        $Totalsell = DB::table('main_table')
                   ->select('*', DB::raw('SUM(detail_table.price) as totalsell'))
                   ->join('detail_table', 'main_table.ID', '=', 'detail_table.main_id')
                   ->where('detail_table.itemtype', 'L')
                   ->whereDate('date', $Today)
                   ->get();
        foreach ($Totalsell as $key => $row) {
            $Totalsell = $row->totalsell;
        }
        $Sellpackagetotal = DB::table('main_package')
                            ->select(DB::raw('SUM(package_detail.fake_price) as sellpackagetotal'))
                            ->join('package_detail', 'main_package.id', '=', 'package_detail.main_package_id')
                            ->whereDate('date', $Today)
                            ->get();
        foreach ($Sellpackagetotal as $key => $row) {
            $Sellpackagetotal = $row->sellpackagetotal;
        }
        $Sumtotal = $Totalsell + $Sellpackagetotal;
        return $Sumtotal;
    }

    public function Get_newmember_pricemax($Today)
    {
        $newmember_pricemax = DB::table('member_detail')
                               ->select(DB::raw('SUM(fullprice) as newmember_pricemax'))
                               ->whereDate('today', $Today)
                               ->get();
        foreach ($newmember_pricemax as $key => $row) {
            $newmember_pricemax = $row->newmember_pricemax;
        }
        return $newmember_pricemax;
    }

    public function Get_newmember_pricediscount($Today)
    {
        $newmember_pricediscount = DB::table('member_detail')
                               ->select(DB::raw('SUM(alldis) as newmember_pricediscount'))
                               ->whereDate('today', $Today)
                               ->get();
        foreach ($newmember_pricediscount as $key => $row) {
            $newmember_pricediscount = $row->newmember_pricediscount;
        }
        return $newmember_pricediscount;
    }

    public function Get_newmember_pricetotal($Today)
    {
        $newmember_pricetotal = DB::table('member_detail')
                               ->select(DB::raw('SUM(resultprice) as newmember_pricetotal'))
                               ->whereDate('today', $Today)
                               ->get();
        foreach ($newmember_pricetotal as $key => $row) {
            $newmember_pricetotal = $row->newmember_pricetotal;
        }
        return $newmember_pricetotal;  
    }

    public function Get_newmember_stopsum($Today)
    {
        $newmember_stopsum = DB::table('member_detail')
                               ->select(DB::raw('SUM(resultprice) as newmember_stopsum'))
                               ->whereDate('today', $Today)
                               ->where('typestatus', 'Stop Member')
                               ->count();
        return $newmember_stopsum;
    }

    public function Get_newmember_stopprice($Today)
    {
        $newmember_stopprice = DB::table('member_detail')
                               ->select(DB::raw('SUM(resultprice) as newmember_stopprice'))
                               ->whereDate('today', $Today)
                               ->where('typestatus', 'Stop Member')
                               ->get();
        foreach ($newmember_stopprice as $key => $row) {
            $newmember_stopprice = $row->newmember_stopprice;
        }
        return $newmember_stopprice ;        
    }



}
