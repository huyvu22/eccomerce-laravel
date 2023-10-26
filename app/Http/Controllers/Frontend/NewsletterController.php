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
        $validator = Validator::make($request->all(),
            [
                'email' => 'required|email',
            ],
            [
                'required' => ':attribute không được để trống'
            ],
            [
                'email' => 'Email'
            ]

        );

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
                    'message' => 'Vui lòng kiểm tra email của bạn để kích hoạt tài khoản',
                ]);

            }else if($existSubscriber->is_verified == 1){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Email đã được đăng ký',
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
                'message' => 'Vui lòng kiểm tra email của bạn để kích hoạt tài khoản',
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
            toastr()->success('Bạn đã kích hoạt email thành công');
        }else {
            toastr()->error('Token hết hạn');
        }

        return redirect()->route('home');
    }

}
