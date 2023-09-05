<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\Contact;
use App\Models\About;
use App\Models\EmailConfig;
use App\Models\TermsAndCondition;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        $about = About::first();
        return view('frontend.pages.about', compact('about'));
    }

    public function termsAndCondition()
    {
        $termsAndCondition = TermsAndCondition::first();
        return view('frontend.pages.terms-and-condition', compact('termsAndCondition'));
    }

    public function contact()
    {
        return view('frontend.pages.contact');
    }

    public function postContactForm(Request $request)
    {
        $request->validate([
            'name' => 'required|max:200',
            'email' => 'required|email',
            'phone' => 'required',
            'subject' => 'required|max:200',
            'message' => 'required',
        ]);

        $setting = EmailConfig::first();
        \Mail::to($setting->email)->send(new Contact($request->subject, $request->message, $request->email));
        toastr()->success('Email sent successfully');
        return redirect()->back();
    }
}
