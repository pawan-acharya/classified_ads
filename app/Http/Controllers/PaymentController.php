<?php

namespace App\Http\Controllers;

use App\Ad;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Constants;
use Auth;
use Lang;
use App\Plan;
use Gabievi\Promocodes\Facades\Promocodes;

class PaymentController extends Controller
{
	public function plans(Request $request) 
	{
		if($request->segment(2)){
			$payment_plan = Constants::PAYMENT_PLANS[$request->segment(2)];
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
			return view('payment.plans', compact('payment_plan', 'checkout_data'));
		}
		return view('payment.plans');
	}

	public function charge(Request $request, $slug = null) {
		try {
			$payment_plan = Constants::PAYMENT_PLANS[$slug];
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
			$ends_at = Carbon::now()->addMonths($payment_plan['validity_months']);

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

			$ad = Ad::latest()->first();
			if($ad) {
				$ad->plan()->associate($plan);
				$ad->save();
			}
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
}
