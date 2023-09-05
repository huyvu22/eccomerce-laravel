<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Province;
use App\Models\ShippingRule;
use App\Models\UserAddress;
use App\Models\Ward;
use Auth;
use Illuminate\Http\Request;

class CheckOutController extends Controller
{
    public function index()
    {
        $addresses =UserAddress::where('user_id', Auth::user()->id)->get();
        $provinces = Province::all();
        $shippingMethods = ShippingRule::where('status',1)->get();
        return view('frontend.pages.checkout', compact('addresses', 'provinces', 'shippingMethods'));
    }

    public function createAddress(Request $request)
    {
        $request->validate([
            'name' => 'required|max:200',
            'email' => 'nullable|email',
            'phone' => 'required',
            'province' => 'required',
            'district' => 'required',
            'ward' => 'required',
            'address' => 'required',
            'note' => 'nullable'
        ]);

        $userAddress = new UserAddress();
        $userAddress->user_id = \Auth::user()->id;
        $userAddress->name = $request->name;
        $userAddress->email = $request->email;
        $userAddress->phone = $request->phone;
        $userAddress->province = Province::find($request->province)->_name;
        $userAddress->district = District::find($request->district)->_name;
        $userAddress->ward = Ward::find($request->ward)->_name;
        $userAddress->address = $request->address;
        $userAddress->note = $request->note;
        $userAddress->save();
        \toastr()->success('Created successfully');
        return \redirect()->route('user.checkout');
    }
    public function getProvince(string $provinceId)
    {
        $districts = District::where('_province_id',$provinceId)->get();
        return  \response([
            'status' => 'success',
            'districts' => $districts
        ]);
    }

    public function getDistrict(string $districtId)
    {
        $wards = Ward::where('_district_id',$districtId)->get();
        return  \response([
            'status' => 'success',
            'wards' => $wards
        ]);
    }

    public function checkOutFormSubmit(Request $request)
    {
       $request->validate([
           "shipping_method_id" => "required|integer",
           "shipping_address_id" => "required|integer",
       ]);

       $shippingMethod = ShippingRule::find($request->shipping_method_id);
       if($shippingMethod){
           \Session::put('shipping_method',[
               'id' => $shippingMethod->id,
               'name' => $shippingMethod->name,
               'type' => $shippingMethod->type,
               'cost' => $shippingMethod->cost,
           ]);
       }


       $address = UserAddress::find($request->shipping_address_id);
       if($address){
           \Session::put('shipping_address',$address);
       }

        return response()->json([
            'status' => 'success',
            'redirect_url' => route('user.payment')
        ]);
    }
}
