<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\VendorWithdrawDataTable;
use App\Http\Controllers\Controller;
use App\Models\OrderProduct;
use App\Models\WithdrawMethod;
use App\Models\WithdrawRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VendorWithdrawController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function totalBalance()
    {
        $vendorId = Auth::user()->vendor->id;

        $totalEarnings = OrderProduct::whereHas('order', function ($query) {
            $query->where('payment_status', 1)->where('order_status', 'delivered');
        })
            ->where('vendor_id', $vendorId)
            ->sum(DB::raw('unit_price * quantity + variant_total'));

        $totalAmountWithdraw = WithdrawRequest::where('vendor_id', $vendorId)
            ->where('status', 'paid')
            ->sum('total_amount');

        return $totalEarnings - $totalAmountWithdraw;
    }

    public function index(VendorWithdrawDataTable $dataTable)
    {
        $vendorId = Auth::user()->vendor->id;
        $totalBalance = $this->totalBalance();

        $pendingAmountRequests = WithdrawRequest::where('vendor_id', $vendorId)
            ->where('status', 'pending')
            ->sum('total_amount');
        $totalAmountWithdraw = WithdrawRequest::where('vendor_id', $vendorId)
            ->where('status', 'paid')
            ->sum('total_amount');

        return $dataTable->render('vendor.withdraw.index', compact('totalBalance', 'pendingAmountRequests', 'totalAmountWithdraw'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $methods = WithdrawMethod::all();

        $totalBalance = $this->totalBalance();

        return view('vendor.withdraw.create', compact('methods', 'totalBalance'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
               'method' => 'required',
               'withdraw_amount' => 'required|numeric',
               'account_info' => 'required',
            ],
            [
                'required' => ':attribute không được để trống',
                'numeric' => ':attribute phải là số',
            ],
            [
                'method' => 'Phương thức thanh toán',
                'withdraw_amount' => 'Số tiền rút',
                'account_info' => 'Thông tin tài khoản',
            ],
        );

        $method = WithdrawMethod::findOrFail($request->method);
        $vendorId = Auth::user()->vendor->id;

        $totalEarnings = OrderProduct::whereHas('order', function ($query) {
            $query->where('payment_status', 1)->where('order_status', 'delivered');
        })
            ->where('vendor_id', $vendorId)
            ->sum(DB::raw('unit_price * quantity + variant_total'));

        if($request->withdraw_amount < $method['minimum_amount'] || $request->withdraw_amount > $method['maximum_amount']){
            toastr('Số tiền rút phải lớn hơn ' .format($method['minimum_amount']). ' và nhỏ hơn '. format($method['maximum_amount']), 'error');
            return redirect()->back();
        }

        if($request->withdraw_amount > $totalEarnings){
            toastr('Số tiền rút vượt quá số dư khả dụng', 'error');
            return redirect()->back();
        }

        if(WithdrawRequest::where(['vendor_id'=>$vendorId, 'status'=>'pending'])->exists()){
            toastr('Có 1 yêu cầu rút tiền trước đó chưa hoàn thành, vui lòng quay lại sau', 'error');
            return redirect()->back();
        }

        $withdraw = new WithdrawRequest();
        $withdraw->vendor_id = Auth::user()->vendor->id;
        $withdraw->method = $method->name;
        $withdraw->total_amount = $request->withdraw_amount;
        $withdraw->withdraw_amount = $request->withdraw_amount - ($request->withdraw_amount / 100)*$method['withdraw_charge'];
        $withdraw->withdraw_charge = ($request->withdraw_amount / 100)*$method['withdraw_charge'];
        $withdraw->account_info = $request->account_info;
        $withdraw->save();

        toastr('Gửi yêu cầu thành công');
        return redirect()->route('vendor.withdraw.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $method = WithdrawMethod::find($id);
        return response($method);
    }

    public function showRequest(string $id)
    {
        $withdrawRequest = WithdrawRequest::where('vendor_id',Auth::user()->vendor->id)->findOrFail($id);
        return view('vendor.withdraw.show', compact('withdrawRequest'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
