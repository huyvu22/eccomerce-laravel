<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Province;
use App\Models\UserAddress;
use App\Models\Ward;
use Illuminate\Http\Request;

class UserAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $userAddress = UserAddress::where('user_id', \Auth::user()->id)->get();
        return \view('frontend.dashboard.address.index', compact('userAddress'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $provinces = Province::all();
        return \view('frontend.dashboard.address.create', compact('provinces',));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
            'name' => 'required|max:200',
            'email' => 'nullable|email',
            'phone' => 'required',
            'province' => 'required',
            'district' => 'required',
            'ward' => 'required',
            'address' => 'required',
            'note' => 'nullable'
            ],
            [
                'required' => ':attribute bắt buộc phải nhập',
            ],
            [
                'name' => 'Tên',
                'email' => 'Email',
                'phone' => 'Số điện thoại',
                'province' => 'Tỉnh, thành phố',
                'district' => 'Quận, huyện',
                'ward' => 'Xã, Phường',
                'address' => 'Địa chỉ',
                'note' => 'Ghi chú'
            ],
        );

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
        toastr()->success('Thêm địa chỉ thành công');
        return \redirect()->route('user.address.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserAddress $address)
    {
        $provinces = Province::all();
        $provinceName = Province::where('_name',$address->province)->first();
        $districts = District::where('_province_id',$provinceName->id)->get();
        $wardName = District::where('_name',$address->district)->first();
        $wards = Ward::where('_district_id',$wardName->id)->get();
        return \view('frontend.dashboard.address.edit', compact('address', 'provinces', 'districts', 'wards'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,UserAddress $address)
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

        $address->user_id = \Auth::user()->id;
        $address->name = $request->name;
        $address->email = $request->email;
        $address->phone = $request->phone;
        $address->province = Province::find($request->province)->_name;
        $address->district = District::find($request->district)->_name;
        $address->ward = Ward::find($request->ward)->_name;
        $address->address = $request->address;
        $address->note = $request->note;
        $address->save();
        \toastr()->success('Cập nhật thành công');
        return \redirect()->route('user.address.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserAddress $address,)
    {
        $address->delete();
        \toastr()->success('Xóa thành công');
        return \redirect()->back();
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
}
