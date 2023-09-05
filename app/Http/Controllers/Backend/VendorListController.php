<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\VendorListDataTable;
use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorListController extends Controller
{
    public function index(VendorListDataTable $dataTable)
    {
        return $dataTable->render('admin.vendor-list.index');
    }

    public function updateStatus(Request $request, Vendor $vendor)
    {
        $vendor->status = $request->switch_status;
        $vendor->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Status updated successfully'
        ]);
    }
}
