<?php

namespace App\Http\Controllers\Frontend;

use App\Helper\MailHepler;
use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscrible;
use Illuminate\Http\Request;
use Mail;
use Str;
use Validator;

class NewsletterController extends Controller
{
    public function newsLetter(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first('email'),
            ]);
        }

        $existSubscriber = NewsletterSubscrible::where('email', $request->email)->first();

        if(!empty($existSubscriber)){
            if($existSubscriber->is_verified == 0) {

				//send link verification again
                $existSubscriber->verified_token = Str::random(25);
                $existSubscriber->save();

                //mail config
                MailHepler::setMailConfig();

                //send mail
                Mail::to($existSubscriber->email)->send(new \App\Mail\SubscriptionVerification($existSubscriber));

                return response()->json([
                    'status' => 'success',
                    'message' => 'Check your email to activate newsletter',
                ]);

            }else if($existSubscriber->is_verified == 1){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Your already subscribed',
                ]);
            }
        }else{
            $subscriber = new NewsletterSubscrible();
            $subscriber->email = $request->email;
            $subscriber->verified_token = Str::random(25);
            $subscriber->is_verified = 0;
            $subscriber->save();

            //mail config
           	MailHepler::setMailConfig();

            //send mail
            Mail::to($subscriber->email)->send(new \App\Mail\SubscriptionVerification($subscriber));

            return response()->json([
                'status' => 'success',
                'message' => 'Check your email to activate newsletter',
            ]);

        }

    }

    public function newsLetterEmailVerify($token)
    {
        $verify =  NewsletterSubscrible::where('verified_token', $token)->first();

        if($verify){
            $verify->verified_token = 'verified';
            $verify->is_verified = 1;
            $verify->save();
            toastr()->success('Email verification successfully');
        }else {
            toastr()->error('Invalid Token');
        }

        return redirect()->route('home');
    }

}
