<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\CustomerListDataTable;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerListController extends Controller
{
    public function index(CustomerListDataTable $dataTable)
    {
        return $dataTable->render('admin.customer-list.index');
    }

    public function updateStatus(Request $request, User $user)
    {
        $user->status = $request->switch_status == 1 ? 'active' : 'inactive';
        $user->save();
        return response()->json([
           'status' => 'success',
            'message' => 'Status updated successfully'
        ]);
    }
}
