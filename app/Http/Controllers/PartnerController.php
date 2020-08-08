<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Lang;
use Mail;
use App\Partner;
use Response;
use Promocodes;
use Gabievi\Promocodes\Models\Promocode;
use App\Mail\PartnerApproved;
use App\Mail\PartnerRejected;
use Constants;

class PartnerController extends Controller
{
    public function create(Request $request)
    {
        return view('partners.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'business_name' => ['required', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'home_phone' => ['required','alpha_dash'],
            'mobile_phone' => ['required','alpha_dash'],
            'city' => ['required','string'],
            'province' => ['required','string'],
            'postal_code' => ['required','alpha_dash'],
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        $data['status'] = 'pending';

        Partner::create($data);
        return redirect()->route('home')->with('status', Lang::get('partners.success'));
    }

    public function reject(Request $request, $id)
    {
        if($request->ajax()){
            try {
                $partner = Partner::find($id);
                $partner->status = 'rejected';
                $partner->save();

                Mail::to($request->user())->send(new PartnerRejected());

                return response()->json($partner);
            } catch (\Exception $e) {
                abort(500, $e->getMessage());
                
            }
           
        }
    }

    public function approve(Request $request)
    {
        if($request->ajax()){
            try {
                //Create promocode
                $reward = $request->get('discount_value') ?: $request->get('discount_percent') ;
                if(!empty($reward)) {
                    if($request->has('discount_value') && $request->get('discount_value') !== null) {
                        $data = [
                            'type' => 'value',
                            'value' => $request->get('discount_value')
                        ];
                    }
                    if($request->has('discount_percent') && $request->get('discount_percent') !== null) {
                        $data = [
                            'type' => 'percent',
                            'value' => $request->get('discount_percent')
                        ];
                    }
                    $promo = Promocodes::create(1, $reward, $data, null, Constants::PROMOCODE_MAX_USAGE)->first();
                    $promocode = Promocode::where('code', $promo['code'])->get();

                    //Send promocode with approval email.
                    Mail::to($request->user())->send(new PartnerApproved(Auth::user(), $promocode->first()));
                }

                $partner = Partner::find($request->get('partner_id'));
                $partner->promocode()->associate($promocode->first());
                $partner->status = 'approved';
                $partner->save();

                return response()->json($partner);
            } catch(\Exception $e) {
                abort(500, $e->getMessage());
            } 
        }
    }
    
}
