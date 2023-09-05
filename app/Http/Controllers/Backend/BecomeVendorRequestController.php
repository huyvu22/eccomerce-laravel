<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\BecomeVendorRequestDataTable;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vendor;


class BecomeVendorRequestController extends Controller
{
    public function index(BecomeVendorRequestDataTable $dataTable)
    {
        return $dataTable->render('admin.become-vendor-request.index');
    }

    public function show(Vendor $vendor)
    {
		return view('admin.become-vendor-request.show', compact('vendor'));
    }

    public function getStatus($id,$status)
    {
        $vendor = Vendor::find($id);
        $vendor->status = $status;
        $vendor->save();

        $user = User::find($vendor->user_id);
        $user->role = 'vendor';
        $user->save();

        return response([
            'status' => $status,
            'message' => 'Updated status successfully'
        ]);
    }
}
