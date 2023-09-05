<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\PermissionDataTable;
use App\Http\Controllers\Controller;
use App\Models\ModulePermission;
use App\Models\Permission;
use Illuminate\Http\Request;


class PermisstionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PermissionDataTable $dataTable)
    {
        $modules = ModulePermission::where('status', 1)->get();
        return $dataTable->render('admin.permission.index', compact('modules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('permissions.add',Permission::class);
        $modules = ModulePermission::where('status', 1)->get();
        $permissions = Permission::all();
        $permissionsArr = json_decode($permissions, true);
        $permissions = [];
        foreach ($permissionsArr as $item) {
            $permissions[$item['group_name']] = $item['name'];
        }

        $roleListArr= [
            'view' =>'View',
            'add' =>'Add',
            'edit' =>'Edit',
            'delete' =>'Delete',
        ];

        return view('admin.permission.create',compact('roleListArr','permissions','modules' ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
//        $permissions = Permission::all();
//        $this->authorize('permissions.edit',$permissions);
        $request->validate([
            'role'=>'required'
        ]);

        if ($request->role){

            $checkPermission = Permission::all();
            if(($checkPermission)){
                $checkPermission->each->delete();
            }
            foreach($request->role as $key=>$role){

                Permission::create([
                    'name' => json_encode($role,true),
                    'group_name' => $key,
                ]);
            }
        }
        toastr('Created Successfully');
        return redirect()->route('admin.permission.index');
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
    public function edit(string $id)
    {


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
