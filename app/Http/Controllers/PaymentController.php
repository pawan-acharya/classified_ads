<?php

namespace App\Http\Controllers;

use App\Ad;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Constants;
use Auth;
use Lang;
use DB;
use App\Plan;
use App\ClassifiedAd;
use Gabievi\Promocodes\Facades\Promocodes;

class PaymentController extends Controller
{
	public function plans($id=null) 
	{
		$plan_list= true;
		$payment_plan['cost']= ClassifiedAd::findOrFail($id)->getCost();
		return view('payment.plans', compact('id', 'plan_list', 'payment_plan'));
	}

	public function plansForm($id) 
	{
		if(Auth::user()->checkIfAdmin() || Auth::user()->ifLeftAds()){
            $plan =Auth::user()->plan;
            $classified_ad= ClassifiedAd::findOrFail($id);
            $classified_ad->plan()->associate($plan);
            $classified_ad->save();
            return redirect()->route('home')->with('status', Lang::get('payments.payment_successful'));
        }

		$payment_plan = Constants::PAYMENT_PLANS['exceptional'];
		$payment_plan['cost']= findTotalAmount($id);
		$checkout_data = [
			'cost' => $payment_plan['cost'],
			'cost_formatted' =>  $payment_plan['cost'],
			'subtotal' => $payment_plan['cost'],
			'tax' => $payment_plan['cost']* Constants::TAX_RATE,
			'total' => $payment_plan['cost'] +  $payment_plan['cost']*Constants::TAX_RATE,
			// 'cost_formatted' => money_format('$%i', $payment_plan['cost']),
			// 'subtotal' => money_format('$%i',$payment_plan['cost']),
			// 'tax' => money_format('$%i',$payment_plan['cost']* Constants::TAX_RATE),
			// 'total' => money_format('$%i', $payment_plan['cost'] +  $payment_plan['cost']*Constants::TAX_RATE),
		];
		$plan_list= false;
		return view('payment.plans', compact('payment_plan', 'checkout_data', 'plan_list', 'id'));
	}

	public function charge(Request $request, $id) {
		// dd('here');
		$slug= 'exceptional';
		try {
			$payment_plan = Constants::PAYMENT_PLANS['exceptional'];
			$total_cost = (float)$payment_plan['cost'];
			$voucher = session()->get('voucher');
			if($voucher) {
				if($voucher->data['type'] === Constants::VOUCHER_TYPES['PERCENT']) {
					$total_cost = $total_cost - ($voucher->reward * $total_cost / 100);
				} elseif($voucher->data['type'] === Constants::VOUCHER_TYPES['VALUE']) {
					$total_cost = $total_cost - $voucher->reward;
				}
			}

			$stripe_cost = (int)($total_cost*100);
			$ends_at = Carbon::now()->addMonths(1);

			$payment = Auth::user()->charge($stripe_cost, $request->input('payment-method') , [
				'metadata' => [
					'plan' => $slug,
					'city' => $request->input('city'),
					'state' => $request->input('state'),
					'country' => 'ca'
				],
			]);
			
			$plan = Plan::create([
				'user_id' => Auth::user()->id,
				'stripe_plan' =>  $payment->id,
				'cost' => $total_cost,
				'slug' =>  $slug,
				'name' => $payment_plan['title'],
				'ends_at' => $ends_at,
				'is_active' => 1
			]);

			$ad = ClassifiedAd::findOrFail($id);
			$ad->plan()->associate($plan);
			$ad->save();
			
			if($voucher){
				Auth::user()->redeemCode($voucher->code);
				session()->forget('voucher');
			}
			return redirect()->route('home')->with('status', Lang::get('payments.payment_successful'));
		} catch (\Exception $e) {
			return redirect()->back()->with('error', $e->getMessage());
		}
	}

	public function voucher(Request $request, $voucher) {
		try {
			$user = Auth::user();
			$promocode = Promocodes::check($voucher);
			if($promocode) {
				if($promocode->data['type'] === Constants::VOUCHER_TYPES['PERCENT']) {
					$message = Lang::get('payments.voucher_successful', ['discount' => $promocode->data['value'].'%'] );
				} if($promocode->data['type'] === Constants::VOUCHER_TYPES['VALUE']) {
					$message =  Lang::get('payments.voucher_successful', ['discount' => $promocode->data['value'].'$'] );
				}

				session()->put('voucher', $promocode);
				$data = $promocode->data;
				return response()->json(compact('message','data'));
			} else {
				throw new \Exception( Lang::get('payments.voucher_not_found'));
			}
					
		} catch (\Exception $e) {
			return abort(500, $e->getMessage());
		}
	}

	public function become_member() 
	{
		$payment_plan = Constants::PAYMENT_PLANS['exceptional'];
		$payment_plan['cost']= 150;
		$checkout_data = [
			'cost' => $payment_plan['cost'],
			'cost_formatted' =>  $payment_plan['cost'],
			'subtotal' => $payment_plan['cost'],
			'tax' => $payment_plan['cost']* Constants::TAX_RATE,
			'total' => $payment_plan['cost'] +  $payment_plan['cost']*Constants::TAX_RATE,
		];
		return view('payment.member.plan', compact('payment_plan', 'checkout_data'));
	}

	public function membership_charge(Request $request){
		$slug= 'exceptional';
		try {
			$payment_plan = Constants::PAYMENT_PLANS['exceptional'];
			$total_cost = (float)$payment_plan['cost'];
			$voucher = session()->get('voucher');
			if($voucher) {
				if($voucher->data['type'] === Constants::VOUCHER_TYPES['PERCENT']) {
					$total_cost = $total_cost - ($voucher->reward * $total_cost / 100);
				} elseif($voucher->data['type'] === Constants::VOUCHER_TYPES['VALUE']) {
					$total_cost = $total_cost - $voucher->reward;
				}
			}

			$stripe_cost = (int)($total_cost*100);
			$ends_at = Carbon::now()->addMonths(1);

			$payment = Auth::user()->charge($stripe_cost, $request->input('payment-method') , [
				'metadata' => [
					'plan' => $slug,
					'city' => $request->input('city'),
					'state' => $request->input('state'),
					'country' => 'ca'
				],
			]);
			
			$plan = Plan::create([
				'user_id' => Auth::user()->id,
				'stripe_plan' =>  $payment->id,
				'cost' => $total_cost,
				'slug' =>  $slug,
				'name' => $payment_plan['title'],
				'ends_at' => $ends_at,
				'is_active' => 1, 
				'type'=> 'membership'
			]);

			$user = Auth::user();
			$user->plan()->associate($plan);
			$user->is_member= 1;
			$user->validated_date= Carbon::now()->addMonth();
			$user->save();
			
			if($voucher){
				Auth::user()->redeemCode($voucher->code);
				session()->forget('voucher');
			}
			return redirect()->route('home')->with('status', Lang::get('payments.payment_successful'));
		} catch (\Exception $e) {
			return redirect()->back()->with('error', $e->getMessage());
		}
	}

	public function bulk_pay(){
		// $totalSum=0;
		// foreach ($request['ids'] as $key => $value) {
		// 	$totalSum+= ClassifiedAd::findOrFail($value)->getCost();
		// }
		// $payment_plan['cost']= $totalSum;
		// request()->session()->forget('ids');
		// request()->session()->push('ids', $request['ids']);
		return view('payment.bulk.plan');
	}

	public function bulk_payment_form($type){
		// if(Auth::user()->checkIfAdmin()){
		// 	$plan =Auth::user()->plan;
		// 	foreach (request()->session()->get('ids')[0] as $key => $value) {
		// 		$ad= ClassifiedAd::findOrFail($value);
		// 		$ad->plan()->associate($plan);
		// 		$ad->save();
		// 	}
		// 	return redirect()->route('home')->with('status', Lang::get('payments.payment_successful'));
		// }

		// $totalSum=0;
		// foreach (request()->session()->get('ids')[0] as $key => $value) {
		// 	$totalSum+= ClassifiedAd::findOrFail($value)->getCost();
		// }
		$payment_plan = Constants::PAYMENT_PLANS['exceptional'];
		switch ($type) {
			case 'ten':
				$totalSum= 75;
				break;
			case 'five':
				$totalSum= 50;
				break;
			default:
				$totalSum= 20;
				break;
		}
		$payment_plan['cost']= $totalSum;
		$checkout_data = [
			'cost' => $payment_plan['cost'],
			'cost_formatted' =>  $payment_plan['cost'],
			'subtotal' => $payment_plan['cost'],
			'tax' => $payment_plan['cost']* Constants::TAX_RATE,
			'total' => $payment_plan['cost'] +  $payment_plan['cost']*Constants::TAX_RATE,
		];
		// request()->session()->push('ids', request()->session()->get('ids')[0]);
		return view('payment.bulk.payment_form', compact('payment_plan', 'checkout_data', 'type'));
	}

	public function bulk_payment_charge(Request $request, $type){
		$slug= 'exceptional';
		try {
			$payment_plan = Constants::PAYMENT_PLANS['exceptional'];
			$total_cost = (float)$payment_plan['cost'];
			$voucher = session()->get('voucher');
			if($voucher) {
				if($voucher->data['type'] === Constants::VOUCHER_TYPES['PERCENT']) {
					$total_cost = $total_cost - ($voucher->reward * $total_cost / 100);
				} elseif($voucher->data['type'] === Constants::VOUCHER_TYPES['VALUE']) {
					$total_cost = $total_cost - $voucher->reward;
				}
			}

			$stripe_cost = (int)($total_cost*100);
			$ends_at = Carbon::now()->addMonths(1);

			$payment = Auth::user()->charge($stripe_cost, $request->input('payment-method') , [
				'metadata' => [
					'plan' => $slug,
					'city' => $request->input('city'),
					'state' => $request->input('state'),
					'country' => 'ca'
				],
			]);
			
			$plan = Plan::create([
				'user_id' => Auth::user()->id,
				'stripe_plan' =>  $payment->id,
				'cost' => $total_cost,
				'slug' =>  $slug,
				'name' => $payment_plan['title'],
				'ends_at' => $ends_at,
				'is_active' => 1,
				'type'=> $type
			]);

			// foreach (json_decode($request['ids'][0], TRUE) as $key => $value) {
			// 	$ad = ClassifiedAd::findOrFail($value);
			// 	$ad->plan()->associate($plan);
			// 	$ad->save();
			// }

			$user = Auth::user();
			$user->plan()->associate($plan);
			$user->validated_date= Carbon::now()->addMonth();
			$user->save();
			
			if($voucher){
				Auth::user()->redeemCode($voucher->code);
				session()->forget('voucher');
			}
			return redirect()->route('home')->with('status', Lang::get('payments.payment_successful'));
		} catch (\Exception $e) {
			return redirect()->back()->with('error', $e->getMessage());
		}
	}
}

function findTotalAmount($id){
	$classified_ad= ClassifiedAd::findOrFail($id);
	switch ($classified_ad->category->type) {
		case 'sales':
			return 20;
			break;
		
		case 'rental':
			return 20;
			break;
		
		default:
			$amount= 0;
			if($classified_ad->url){
				$amount++;
			}
			if($classified_ad->files()->count() >6 ){
				$amount+= 5;
			}
			if($classified_ad->is_featured){
				switch ($classified_ad->feature_type) {
					case 'week':
						$amount+= 8;
						break;
					
					case 'month':
						$amount+= 20;
						break;
					
					default:
						$amount+= 5;
						break;
				}
			}
			return $amount;
			break;
	}
}
