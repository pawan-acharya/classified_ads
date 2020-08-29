<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use DB;
use Lang;
use Constants;
use Carbon\Carbon; 
use App\User;
use App\Partner;
use App\Plan;
use App\Ad;
use App\ClassifiedAd;


class AdminController extends Controller
{
    public function index(Request $request) {

        $salesFilter = $request->query('sales');   

        $usersCount = DB::table('users')->count();
        // $partnersCount = DB::table('partners')->count();
        $adsCount = DB::table('classified_ads')->count();
        // $totalSales = DB::table('plans')->sum('cost');
        $categoriesCount= DB::table('categories')->count();

        if($salesFilter == 'last_month') {
            $date = \Carbon\Carbon::today()->subMonth(1);
        } else if($salesFilter == 'last_year') {
            $date = \Carbon\Carbon::today()->subYear(1);
        } else {
            $date = \Carbon\Carbon::today()->subDays(7);
        }
        
        $sales = Plan::select('id', 'slug', 'cost', 'created_at')
        ->orderBy('created_at', 'asc')
        ->where('created_at', '>=', $date)
        ->get()
        ->groupBy(function($date) use ($salesFilter) {
            if($salesFilter == 'last_year') {
                return Carbon::parse($date->created_at)->format('Y-m'); // grouping by months
            }
            return Carbon::parse($date->created_at)->format('Y-m-d'); // grouping by months
        });
        
        $totalSalesData = [];
        foreach ($sales as $key => $data) {
            $totalSalesData[$key] = number_format($data->sum('cost'), 2, '.', '');
        }

        $sales = Plan::select('id', 'slug', 'created_at')
        ->orderBy('created_at', 'asc')
        ->get()
        ->groupBy('slug');
        $monthlySalesCount = [];
        foreach ($sales as $key => $data) {
            $monthlySalesCount[Lang::get('payments.payment_plans.'.$key.'.title')] = count($data);
        }

        return view('admin.index', compact('usersCount', 'adsCount', 'monthlySalesCount', 'totalSalesData', 'categoriesCount'));
    }



    public function history(Request $request) {
        if($request->ajax()){
            $data = ClassifiedAd::latest('created_at')->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('category_name', function($row){
                         return $row->category->category_name;
                     })
                    ->addColumn('actions', function($row){
                        $url= route("classified_ads.toggle", ["classified_ad"=>$row->id]);
                        if ($row->approved === 1) {
                            $btns = '<a href="'.$url.'" class="btn btn-success btn-sm">'.Lang::get('admin.approved').'</a>';
                            return $btns;
                        } elseif ($row->approved === 0) {
                            $btns = '<a href="'.$url.'" class="btn btn-danger btn-sm">'.Lang::get('admin.rejected').'</a>';
                            return $btns;
                        }
                    })
                    ->rawColumns(['actions'])
                    ->make(true);
        }
    }
}
