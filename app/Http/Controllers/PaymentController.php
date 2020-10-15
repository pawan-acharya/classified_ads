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
        $classified_ad= ClassifiedAd::findOrFail($id);
		if(Auth::user()->checkIfAdmin() || Auth::user()->ifLeftAds($classified_ad->category->type) || findTotalAmount($id)<=0){
            $plan =Auth::user()->plan;
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
		$slug= 'exceptional';
		try {
			$payment_plan = Constants::PAYMENT_PLANS['exceptional'];
			$total_cost = (float)(findTotalAmount($id) + findTotalAmount($id)*0.14975);
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
			$total_cost = (float)(150 + 150*0.14975);
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

	public function bulk_payment_form($type, $package_type){
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

		
		$payment_plan['cost']= getPlanAmount($type);
		$checkout_data = [
			'cost' => $payment_plan['cost'],
			'cost_formatted' =>  $payment_plan['cost'],
			'subtotal' => $payment_plan['cost'],
			'tax' => $payment_plan['cost']* Constants::TAX_RATE,
			'total' => $payment_plan['cost'] +  $payment_plan['cost']*Constants::TAX_RATE,
		];
		// request()->session()->push('ids', request()->session()->get('ids')[0]);
		return view('payment.bulk.payment_form', compact('payment_plan', 'checkout_data', 'type', 'package_type'));
	}

	public function bulk_payment_charge(Request $request, $type, $package_type){
		$slug= 'exceptional';
		try {
			$payment_plan = Constants::PAYMENT_PLANS['exceptional'];
			$total_cost = (float)(getPlanAmount($type) + getPlanAmount($type)*0.14975);
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
				'type'=> $type,
				'package_type'=> $package_type
			]);

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

	public function edit_pay($id){
		$total_amount= findTotalAmountOfRequest(request()->session()->get('requests'));
		$amount_paid= findTotalAmount($id);
		// ClassifiedAd::findOrFail($id)->plan->cost- (float)(0.14975* ClassifiedAd::findOrFail($id)->plan->cost) ;
		$additional_amount= $total_amount- $amount_paid;
		// dd($total_amount, $amount_paid, $additional_amount);
		if(!$additional_amount){
			return redirect()->route('classified_ad.update', ['classified_ad'=> $id]);
		}
		return view('payment.edit.plan', compact('amount_paid', 'additional_amount', 'id'));
	}

	public function edit_payment_form($id){
		$type= 'exceptional';
		$payment_plan = Constants::PAYMENT_PLANS['exceptional'];

		$total_amount= findTotalAmountOfRequest(request()->session()->get('requests'));
		$amount_paid= findTotalAmount($id);
		// ClassifiedAd::findOrFail($id)->plan->cost- (0.14975* ClassifiedAd::findOrFail($id)->plan->cost) ;
		$additional_amount= $total_amount- $amount_paid;

		$payment_plan['cost']= $additional_amount;
		$checkout_data = [
			'cost' => $payment_plan['cost'],
			'cost_formatted' =>  $payment_plan['cost'],
			'subtotal' => $payment_plan['cost'],
			'tax' => $payment_plan['cost']* Constants::TAX_RATE,
			'total' => $payment_plan['cost'] +  $payment_plan['cost']*Constants::TAX_RATE,
		];
		request()->session()->push('requests', request()->session()->get('requests'));
		return view('payment.edit.payment_form', compact('payment_plan', 'checkout_data', 'type', 'id'));
	}

	public function edit_payment_charge(Request $request, $id){
		$slug= 'exceptional';
		try {
			$payment_plan = Constants::PAYMENT_PLANS['exceptional'];

			$total_amount= findTotalAmountOfRequest(request()->session()->get('requests'));
			$amount_paid= findTotalAmount($id);
			// ClassifiedAd::findOrFail($id)->plan->cost- (0.14975* ClassifiedAd::findOrFail($id)->plan->cost) ;
			$additional_amount= $total_amount- $amount_paid;
			$total_cost = (float)($additional_amount + $additional_amount*0.14975);

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

			$ad = ClassifiedAd::findOrFail($id);
			$plan= $ad->plan;
			$plan->cost+= $total_cost;
			$plan->save(); 
			$ad->approved= 0;
			$ad->save();
			
			if($voucher){
				Auth::user()->redeemCode($voucher->code);
				session()->forget('voucher');
			}
			request()->session()->push('requests', request()->session()->get('requests'));
			return redirect()->route('classified_ads.update', $id);
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

function findTotalAmountOfRequest($request){
	// dd($request[0]);
	$total_amount= 0;
	$classified_ad= $request[0];
	if(array_key_exists('url', $classified_ad)){
		$total_amount+= 1;
	}
	// if(){
	// 	title_images
	// }
	if(array_key_exists('is_featured', $classified_ad) && array_key_exists('feature_type', $classified_ad)){
		$total_amount+= getPlanAmount($classified_ad['feature_type']);
	}
	return $total_amount;
}

function getPlanAmount($type){
	switch ($type) {
		case 'ten':
			return 75;
			break;
		case 'five':
			return 50;
			break;
		default:
			return 20;
			break;
	}
}
