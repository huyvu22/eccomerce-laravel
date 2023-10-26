<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\CouponDataTable;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CouponDataTable $dataTable)
    {
        return $dataTable->render('admin.coupon.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('coupon.add',Coupon::class);
        return view('admin.coupon.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:200',
            'code' => 'required|integer',
            'quantity' => 'required|integer',
            'max_use' => 'required|integer',
            'start_date' => 'required',
            'end_date' => 'required',
            'discount_type' => 'required',
            'discount_value' => 'required',
            'status' => 'required',
        ]);
        $coupon = new Coupon();
        $coupon->name = $request->name;
        $coupon->code = $request->code;
        $coupon->quantity = $request->quantity;
        $coupon->max_use = $request->max_use;
        $coupon->start_date = $request->start_date;
        $coupon->end_date = $request->end_date;
        $coupon->discount_type = $request->discount_type;
        $coupon->discount_value = $request->discount_value;
        $coupon->status = $request->status;
        $coupon->total_used = 0;
        $coupon->save();
        toastr()->success('Created Successfully');
        return redirect()->route('admin.coupon.index');
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
    public function edit(Coupon $coupon)
    {
        $this->authorize('coupon.edit',$coupon);
        return view('admin.coupon.edit', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Coupon $coupon)
    {
        $this->authorize('coupon.edit',$coupon);

        if (!$request->has('switch_status')) {
            $request->validate([
                'name' => 'required|max:200',
                'code' => 'required|integer',
                'quantity' => 'required|integer',
                'max_use' => 'required|integer',
                'start_date' => 'required',
                'end_date' => 'required',
                'discount_type' => 'required',
                'discount_value' => 'required',
                'status' => 'required',
            ]);
        }

        if ($request->has('switch_status')) {
            $coupon->status = $request->switch_status;
            $coupon->save();
            return response(['message' =>'Status has been updated!']);
        } else {
            $coupon->name = $request->name;
            $coupon->code = $request->code;
            $coupon->quantity = $request->quantity;
            $coupon->max_use = $request->max_use;
            $coupon->start_date = $request->start_date;
            $coupon->end_date = $request->end_date;
            $coupon->discount_type = $request->discount_type;
            $coupon->discount_value = $request->discount_value;
            $coupon->status = $request->status;
            $coupon->total_used = 0;
            $coupon->save();
            toastr()->success('Update Successfully');
            return redirect()->route('admin.coupon.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Coupon $coupon)
    {
        $this->authorize('coupon.delete',$coupon);
       $coupon->delete();
        toastr()->success('Deleted Successfully');
        return redirect()->back();
    }
}
