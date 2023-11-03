<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\WithdrawRequestDataTable;
use App\Http\Controllers\Controller;
use App\Models\WithdrawRequest;

class WithdrawController extends Controller
{
    public function index(WithdrawRequestDataTable $dataTable)
    {
        return $dataTable->render('admin.withdraw.index');
    }

    public function show(WithdrawRequest $withdrawRequest)
    {
        return view('admin.withdraw.show', compact('withdrawRequest'));
    }

    public function update($id, $status)
    {
        $withdrawRequest = WithdrawRequest::findOrFail($id);
        $withdrawRequest->status = $status;
        $withdrawRequest->save();

        return response(['message' =>'Status has been updated!']);
    }
}
