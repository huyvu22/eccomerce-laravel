<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ModulePermission;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AddRolePermissionController extends Controller
{
    public function addRolePermission(Request $request,Role $role)
    {
        $modules = ModulePermission::where('status', 1)->get();

        $permissionList = [];
        if($role->permission !== "null" && $role->permission){
            foreach (json_decode($role->permission) as $key=>$item){
                $permissionList[$key] = $item;
            }
        }


        $roleList = Permission::all();
        $roleLists = [];
        foreach ($roleList as $roleItem) {
               $roleItemArr = [];
               foreach (json_decode($roleItem->name) as $item) {
                  $roleItemPart = explode(".", $item);
                   $roleItemArr[] = $roleItemPart[1];
               }
               $roleLists[$roleItem->group_name] = $roleItemArr;
        }

        return view('admin.role-permission.index', compact('modules','role','roleLists','permissionList'));
    }

    public function updateRolePermission(Request $request, $id)
    {
        $role = Role::find($id);
        $role->permission = json_encode($request->role);
        $role->save();
        toastr('Permission has been updated');
        return redirect()->back();
    }
}


