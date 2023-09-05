<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\RoleDataTable;
use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;


class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(RoleDataTable $dataTable)
    {
        return $dataTable->render('admin.role.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('role-permission.add',Role::class);
        return view('admin.role.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
        'name'=>'required'
        ]);

        Role::create([
           'name' => $request->name,
        ]);

        toastr('Created Successfully');
        return redirect()->route('admin.role.index');
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
    public function edit(Role $role)
    {
        $this->authorize('role-permission.edit',$role);
        return view('admin.role.edit',compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $this->authorize('role-permission.edit',$role);
        $request->validate([
            'name'=>'required'
        ]);
        $role->name = $request->name;
        $role->save();
        toastr('Updated Successfully');
        return redirect()->route('admin.role.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $this->authorize('role-permission.delete',$role);
        if($role->permission == null || $role->permission == 'null'){
            $role->delete();
            toastr('Deleted Successfully');
        }else{
            toastr('Cannot delete this user role as it has associated permissions.','error');
        }
        return redirect()->back();

    }

}
