<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use File;
use Illuminate\Support\Facades\Hash;

class UserProfileController extends Controller
{
    public function index()
    {
        return view('frontend.dashboard.profile');
    }

    public function updateProfile(Request $request)
    {
        $user= Auth::user();
        $request->validate([
            'name'=>'required',
            'email' =>'required|email|unique:users,email,' .$user->id,
            'image' =>'image|max:2048'
        ]);

        //upload image to public/uploads
        if($request->hasFile('image')){
            //Delete old image
            if( File::exists(public_path($user->image))){
                File::delete(public_path($user->image));
            }

            $image= $request->image;
            $imageName= rand().'_'.$image->getClientOriginalName();
            $image->move(public_path('uploads'),$imageName);

            $path = "/uploads/".$imageName;
            $user->image=$path;
        }

        $user->name=$request->name;
        $user->email=$request->email;
        $user->save();
        toastr()->success('Profile updated successfully');
        return redirect()->back();
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password'=>'required|current_password',
            'password'=>'required|min:8',
            'confirm_password'=>'required|same:password',
        ]);

        $request->user()->update([
            'password'=>Hash::make($request->password)
        ]);
        toastr()->success('Password updated successfully');

        return redirect()->back();
    }
}
