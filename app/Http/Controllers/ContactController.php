<?php

namespace App\Http\Controllers;

use App\Mail\EnquirySubmitted;
use Illuminate\Http\Request;
use Mail;
use Lang;

class ContactController extends Controller
{

    public function index() {
        return view('/pages/contact');
    }

    public function mail(Request $request) { 
        $recipient = config('mail.from.address');
        $request->validate([
            'email' => 'required|email',
            'last_name' => 'required',
            'subject' => 'required',
            'message' => 'required'
        ]);

        Mail::to($recipient)->send(new EnquirySubmitted($request->all()));

        return redirect()->route('contact.index')->with('status', Lang::get('pages.successful'));
    }
}
