<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserProfileController extends Controller
{
    public function index()
    {
        return view('frontend.dashboard.profile');
    }

    public function updateProfile(Request $request)
    {
        $user= Auth::user();
        $request->validate(
            [
                'name'=>'required',
                'email' =>'required|email|unique:users,email,' .$user->id,
                'image' =>'image|max:2048'
            ],
            [
                'required' =>':attribute bắt buộc phải nhập',
                'email' =>':attribute không đúng định dạng',
                'image' => ':attribute phải là ảnh',
                'unique' => ':attribute đã tồn tại',
            ],
            [
                'name' => 'Tên',
                'email' => 'Email',
                'image' => 'Ảnh',
            ]
        );

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
        toastr()->success('Cập nhật thành công');
        return redirect()->back();
    }

    public function updatePassword(Request $request)
    {
        $request->validate(
            [
                'current_password'=>'required|current_password',
                'password'=>'required|min:8',
                'confirm_password'=>'required|same:password',
            ],
            [
                'required' =>':attribute bắt buộc phải nhập',
                'email' =>':attribute không đúng định dạng',
                'confirmed' => ':attribute mới không khớp',
                'min' => ':attribute phải có 8 ký tự',
                'same' => ':attribute không khớp',
                'current_password' => ':attribute không đúng',
            ],
            [
                'current_password' => 'Mật khẩu cũ',
                'password' => 'Mật khẩu mới',
                'confirm_password' => 'Nhập lại mật khẩu',
            ]
        );

        $request->user()->update([
            'password'=>Hash::make($request->password),
            'remember_token' => Str::random(60),
        ]);
        toastr()->success('Mật khẩu cập nhật thành công');

        return redirect()->back();
    }
}
