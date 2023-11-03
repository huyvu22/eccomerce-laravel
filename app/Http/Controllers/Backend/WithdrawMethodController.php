<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\WithdrawMethodDataTable;
use App\Http\Controllers\Controller;
use App\Models\WithdrawMethod;
use Illuminate\Http\Request;

class WithdrawMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(WithdrawMethodDataTable $dataTable)
    {
        return $dataTable->render('admin.withdraw-method.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.withdraw-method.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'minimum_amount' => 'required|numeric|lt:maximum_amount',
            'maximum_amount' => 'required|numeric|gt:minimum_amount',
            'withdraw_charge' => 'required|numeric',
            'description' => 'required',
        ]);

        $withdrawMethod = new WithdrawMethod();
        $withdrawMethod->name = $request->name;
        $withdrawMethod->minimum_amount = $request->minimum_amount;
        $withdrawMethod->maximum_amount = $request->maximum_amount;
        $withdrawMethod->withdraw_charge = $request->withdraw_charge;
        $withdrawMethod->description = $request->description;
        $withdrawMethod->save();
        toastr('Created Successfully');
        return redirect()->route('admin.withdraw-method.index');
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
    public function edit(WithdrawMethod $withdrawMethod)
    {
        return view('admin.withdraw-method.edit', compact('withdrawMethod'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WithdrawMethod $withdrawMethod, Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'minimum_amount' => 'required|numeric|lt:maximum_amount',
            'maximum_amount' => 'required|numeric|gt:minimum_amount',
            'withdraw_charge' => 'required|numeric',
            'description' => 'required',
        ]);


        $withdrawMethod->name = $request->name;
        $withdrawMethod->minimum_amount = $request->minimum_amount;
        $withdrawMethod->maximum_amount = $request->maximum_amount;
        $withdrawMethod->withdraw_charge = $request->withdraw_charge;
        $withdrawMethod->description = $request->description;
        $withdrawMethod->save();
        toastr('Update Successfully');
        return redirect()->route('admin.withdraw-method.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WithdrawMethod $withdrawMethod)
    {
        $withdrawMethod->delete();
        return redirect()->back();
    }
}
