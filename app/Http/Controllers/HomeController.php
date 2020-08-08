<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth,Mail,Lang;
use App\Ad;
use App\User;
use App\Mail\CreateAccount;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $allAds = $user->ads()->orderBy('created_at', 'desc')->get();
        $expiredAds = $allAds->filter(function ($ad, $key) {
            return $ad->has_expired == true;
        });
        $ads = $allAds->filter(function ($ad, $key) {
            return $ad->has_expired == false;
        });

        $referrals = User::where('referred_by', $user->id)->get();
        $totalAdsReferred = 0;
        foreach($referrals as $referral) {
            $referredAdsCount = Ad::where('user_id', $referral->id)->count();
            $totalAdsReferred = $totalAdsReferred + $referredAdsCount;
        }
        
        return view('dashboard', compact('user', 'ads', 'expiredAds', 'totalAdsReferred'));
    }

    
    public function edit(Request $request) {
        $user = Auth::user();
        return view('auth.edit', compact('user'));
    }

    public function update(Request $request) {
        $validationRules = [
            'first_name' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'home_phone' => ['required','alpha_dash'],
            'mobile_phone' => ['alpha_dash'],
            'city' => ['required','string'],
            'province' => ['required','string'],
            'postal_code' => ['required','alpha_dash'],
            'security_question' => ['required','string'],
            'security_answer' => ['required','string'],
        ];
        $data = $request->all();
        if($data['password']) {
            $validationRules['password'] = ['string', 'min:8', 'confirmed'];
        }
        $request->validate($validationRules);
       

        User::where('id', Auth::user()->id)
            ->update([
                'first_name' => $data['first_name'],
                'name' => $data['name'],
                'home_phone' => $data['home_phone'],
                'mobile_phone' => $data['mobile_phone'],
                'city' => $data['city'],
                'province' => $data['province'],
                'postal_code' => $data['postal_code'],
                'correspondence_language' => $data['correspondence_language'],
                'heard_about' => $data['heard_about'],
                'security_question' => $data['security_question'],
                'security_answer' => $data['security_answer'],
            ]);
        if($data['password']) {
            User::where('id', Auth::user()->id)
            ->update([
                'password' => Hash::make($data['password'])
            ]);
        }
        return redirect()->route('home')->with('status', Lang::get('auth.edit_successful'));
    }

    public function invite(Request $request)
    {
       

        try {
            $request->validate([
                'emails.0' => 'required|email'
            ]);
            
            foreach ($request->get('emails') as $recipient) {
                Mail::to($recipient)->send(new CreateAccount(Auth::user()));
            }
            return response()->json([
                'success' => 'true',
                'message' => Lang::get('auth.sent_success'),
            ]);
        } catch(\Exception $e) {
            abort(500, Lang::get('auth.'.$e->getMessage()));
        } 
    }
}
