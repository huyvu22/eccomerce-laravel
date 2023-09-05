<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ShippingRuleDataTable;
use App\Http\Controllers\Controller;
use App\Models\ShippingRule;
use Illuminate\Http\Request;

class ShippingRuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ShippingRuleDataTable $dataTable)
    {
        return $dataTable->render('admin.shipping-rule.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.shipping-rule.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:200',
            'type' => 'required',
            'min_cost' => 'nullable|integer',
            'cost' => 'required|integer',
            'status' => 'required',
        ]);
        $shippingRule = new ShippingRule();
        $shippingRule->name = $request->name;
        $shippingRule->type = $request->type;
        $shippingRule->min_cost = $request->min_cost;
        $shippingRule->cost = $request->cost;
        $shippingRule->status = $request->status;
        $shippingRule->save();
        toastr()->success('Created Successfully');
        return redirect()->route('admin.shipping-rule.index');
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
    public function edit(ShippingRule $shippingRule)
    {
        return view('admin.shipping-rule.edit',compact('shippingRule'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ShippingRule $shippingRule)
    {
        if (!$request->has('switch_status')) {
            $request->validate([
                'name' => 'required|max:200',
                'type' => 'required',
                'min_cost' => 'nullable|integer',
                'cost' => 'required|integer',
                'status' => 'required',
            ]);
        }

        if ($request->has('switch_status')) {
            $shippingRule->status = $request->switch_status;
            $shippingRule->save();
            return response(['message' =>'Status has been updated!']);
        } else {
            $shippingRule->name = $request->name;
            $shippingRule->type = $request->type;
            $shippingRule->min_cost = $request->min_cost;
            $shippingRule->cost = $request->cost;
            $shippingRule->status = $request->status;
            $shippingRule->save();
            toastr()->success('Updated Successfully');
            return redirect()->route('admin.shipping-rule.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShippingRule $shippingRule)
    {
        $shippingRule->delete();
        toastr()->success('Delete Successfully');
        return redirect()->back();
    }
}
