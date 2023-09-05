<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\AdminListDataTable;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminListController extends Controller
{
    public function index(AdminListDataTable $dataTable)
    {
        return $dataTable->render('admin.admin-list.index');
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

    public function destroy(User $user)
    {
        $products = $user->vendor->products;

        if(count($products)>0){
            toastr()->error("Can not deleted admin, you must delete all admin's products first, or ban this account instead of ",'error');
            return redirect()->back();
        }

        $user->vendor()->delete();
        $user->delete();
        toastr()->success('Deleted successfully!');
        return redirect()->back();
    }
}
