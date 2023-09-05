<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Mail\AccountCreateMail;
use App\Models\User;
use App\Models\Vendor;
use Hash;
use Illuminate\Http\Request;
use Mail;

class ManageUserController extends Controller
{
    public function index()
    {
		return view('admin.manage-user.index');
    }

    public function create(Request $request)
    {
		$request->validate([
            'name' => 'required|max:200',
            'email' => 'required|email|unique:users|email',
            'password' => 'required|min:8',
            'confirm_password' => 'same:password',
            'role' => 'required',
        ]);

		$user = new User();
        if($request->role == 'user'){
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = 'user';
            $user->status = 'active';
            $user->save();

            Mail::to($request->email)->send(new AccountCreateMail($request->name,$request->email, $request->password));
            toastr()->success('User created successfully');
            return redirect()->back();

        }elseif ($request->role == 'vendor'){
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = 'vendor';
            $user->status = 'active';
            $user->save();

            $vendor = new Vendor();
            $vendor->banner = 'uploads/1213.jpg';
            $vendor->shop_name = $request->name.'Shop';
            $vendor->phone = '123456789';
            $vendor->email = 'test@gmail.com';
            $vendor->address = 'Ha Noi';
            $vendor->description = 'description shop';
            $vendor->user_id = $user->id;
            $vendor->status = 1;
            $vendor->save();

            Mail::to($request->email)->send(new AccountCreateMail($request->name,$request->email, $request->password));
            toastr()->success('Vendor created successfully');
            return redirect()->back();

        }elseif ($request->role == 'admin'){
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = 'admin';
            $user->status = 'active';
            $user->save();

            $vendor = new Vendor();
            $vendor->banner = 'uploads/1213.jpg';
            $vendor->shop_name = $request->name.'Shop';
            $vendor->phone = '123456789';
            $vendor->email = 'test@gmail.com';
            $vendor->address = 'Ha Noi';
            $vendor->description = 'description shop';
            $vendor->user_id = $user->id;
            $vendor->status = 1;
            $vendor->save();

            Mail::to($request->email)->send(new AccountCreateMail($request->name,$request->email, $request->password));
            toastr()->success('Vendor created successfully');
            return redirect()->back();
        }elseif ($request->role == 'staff'){
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = 'staff';
            $user->status = 'active';
            $user->save();

            Mail::to($request->email)->send(new AccountCreateMail($request->name,$request->email, $request->password));
            toastr()->success('Staff created successfully');
            return redirect()->back();
        }

    }
}
