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


class AdminController extends Controller
{
    public function index(Request $request) {

        $salesFilter = $request->query('sales');   

        $usersCount = DB::table('users')->count();
        $partnersCount = DB::table('partners')->count();
        $adsCount = DB::table('ads')->count();
        $totalSales = DB::table('plans')->sum('cost');

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

        return view('admin.index', compact('usersCount', 'partnersCount', 'adsCount', 'totalSales', 'monthlySalesCount', 'totalSalesData'));
    }

    public function partners(Request $request) {
        if($request->ajax()){
            $data = Partner::latest()->where('status', 'pending')->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('actions', function($row){
                        if($row->status === 'pending') {
                            $btns = '<button type="button" data-toggle="modal" data-target="#approve-modal" data-id="'. $row->id .'" data-action-type="approve" class="approve btn btn-success btn-sm">'.Lang::get('admin.approve').'</button>';
                            $btns .= '<a href="javascript:void();" data-id="'. $row->id .'" class="reject btn btn-danger btn-sm">'.Lang::get('admin.reject').'</a>';
                            return $btns;
                        }
                    })
                    ->rawColumns(['actions'])
                    ->editColumn('province', function ($row) {
                        $province_langkey = 'auth.province_options.'.$row->province;
                        return Lang::get($province_langkey);
                    })
                    ->make(true);
        }
    }

    public function partnerSales(Request $request) {
        if($request->ajax()){
            $data = Partner::latest()
                            ->where('status', 'approved')
                            ->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('promocode', function($row){
                        return $row->promocode->code;
                    })
                    ->rawColumns(['promocode'])
                    ->addColumn('promocode_usage', function($row){
                        return Constants::PROMOCODE_MAX_USAGE - (integer)$row->promocode->quantity;
                    })
                    ->rawColumns(['promocode_usage'])
                    ->addColumn('promocode_value', function($row){
                        if($row->promocode->data['type'] == "value"):
                            // $value = money_format('$%i', $row->promocode->data['value']);
                            $value =  $row->promocode->data['value'];
                        else:
                            $value = $row->promocode->data['value'].'%';
                        endif; 
                        return  $value;
                    })
                    ->rawColumns(['promocode_value'])
                    ->addColumn('total_referrals', function($row){
                        $referrals = User::where('referred_by', $row->user_id)->get();
                        $totalAdsReferred = 0;
                        foreach($referrals as $referral) {
                            $referredAdsCount = Ad::where('user_id', $referral->id)->count();
                            $totalAdsReferred = $totalAdsReferred + $referredAdsCount;
                        }
                        return $totalAdsReferred;
                    })
                    ->rawColumns(['total_referrals'])
                    ->addColumn('total_sales', function($row){
                        $referrals = User::where('referred_by', $row->user_id)->get();
                        $totalAdsRevenue = 0;
                        foreach($referrals as $referral) {
                            $ads = Ad::where('user_id', $referral->id)->get();
                            foreach( $ads as $ad) {
                                $totalAdsRevenue = $totalAdsRevenue + $ad->plan->cost;
                            }
                        }
                        // return money_format('$%i', $totalAdsRevenue);
                        return $totalAdsRevenue;
                    })
                    ->rawColumns(['total_sales'])
                    ->addColumn('sales', function($row){
                        return json_encode($row);
                    })
                    ->rawColumns(['sales'])
                    ->make(true);
        }
    }

    public function history(Request $request) {
        if($request->ajax()){
            $data = Partner::latest()->where('status', '!=', 'pending')->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('actions', function($row){
                        if ($row->status === 'approved') {
                            $btns = '<a href="javascript:void();" class="btn btn-success btn-sm">'.Lang::get('admin.approved').'</a>';
                            return $btns;
                        } elseif ($row->status === 'rejected') {
                            $btns = '<a href="javascript:void();" class="btn btn-danger btn-sm">'.Lang::get('admin.rejected').'</a>';
                            return $btns;
                        }
                    })
                    ->rawColumns(['actions'])
                    ->editColumn('province', function ($row) {
                        $province_langkey = 'auth.province_options.'.$row->province;
                        return Lang::get($province_langkey);
                    })
                    ->make(true);
        }
    }
}
