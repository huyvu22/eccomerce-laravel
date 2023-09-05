<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ModulePermissionDataTable;
use App\Http\Controllers\Controller;
use App\Models\ModulePermission;
use Illuminate\Http\Request;

class ModulePermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ModulePermissionDataTable $dataTable)
    {
        return $dataTable->render('admin.module-permission.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('module-permission.add',ModulePermission::class);
        return view('admin.module-permission.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'title' => 'required',
            'status' => 'required',
        ]);

       ModulePermission::create([
            'name' => $request->name,
            'title' => $request->title,
            'status' => $request->status,
        ]);

        toastr('Created Successfully');
        return redirect()->route('admin.modules.index');
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
    public function edit(ModulePermission $module)
    {
        $this->authorize('module-permission.edit',$module);
        return view('admin.module-permission.edit',compact('module'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ModulePermission $module)
    {
        $this->authorize('module-permission.edit',$module);
        if (!$request->has('switch_status')) {
            $request->validate([
                'name' => 'required',
                'title' => 'required',
                'status' => 'required',
            ]);
        }

        if ($request->has('switch_status')) {
            $module->status = $request->switch_status;
            $module->save();
            return response(['message' =>'Status has been updated!']);
        } else {
            $module->name = $request->name;
            $module->title = $request->title;
            $module->status = $request->status;
            $module->save();

            toastr('Updated Successfully');
            return redirect()->route('admin.modules.index');
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ModulePermission $module)
    {
        $this->authorize('module-permission.delete',$module);

       if($module->permissions == null || $module->permissions == 'null'){
           $module->delete();
           toastr('Deleted Successfully');
       }else{
           toastr('Cannot delete this module as it has associated permissions.','error');
       }

        return redirect()->back();
    }
}
