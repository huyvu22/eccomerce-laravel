<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Models\VendorCondition;
use Auth;
use Illuminate\Http\Request;

class BecomeAVendorRequestController extends Controller
{
    use \App\Traits\ImageUploadTrait;
    public function index()
    {
        $condition = VendorCondition::first();
        return view('frontend.dashboard.become-vendor.index', compact('condition'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'shop_banner' => 'required|image|max:2048',
            'shop_name' => 'required|max:200',
            'shop_mail' => 'required|email',
            'shop_phone' => 'required',
            'shop_address' => 'required',
            'shop_about' => 'required',
        ]);

        if(Auth::user()->role == 'vendor'){
            return redirect()->back();
        }

        $imagePath = $this->uploadImage($request, 'shop_banner','uploads');

        $vendor = new Vendor();
        $vendor->user_id = \Auth::user()->id;
        $vendor->banner = $imagePath;
        $vendor->shop_name = $request->shop_name;
        $vendor->email = $request->shop_mail;
        $vendor->phone = $request->shop_phone;
        $vendor->address = $request->shop_address;
        $vendor->description = $request->shop_about;
        $vendor->status = 0;
        $vendor->save();

        toastr()->success('Submitted successfully! Please wait for approval!');
        return redirect()->back();
    }
}
