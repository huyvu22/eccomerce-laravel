<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Product $product): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        $userRole = $user->role;
        $permission = Role::where('name',$userRole)->first();
        $roleJson = $permission->permission;
        if(!empty($roleJson)){
            $roleArray = json_decode($roleJson,true);
            return isRole($roleArray, 'product','product.add');
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Product $product): bool
    {
        $userRole = $user->role;
        $permission = Role::where('name',$userRole)->first();
        $roleJson = $permission->permission;
        if(!empty($roleJson)){
            $roleArray = json_decode($roleJson,true);
            return isRole($roleArray, 'product','product.edit');
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Product $product): bool
    {
        $userRole = $user->role;
        $permission = Role::where('name',$userRole)->first();
        $roleJson = $permission->permission;
        if(!empty($roleJson)){
            $roleArray = json_decode($roleJson,true);
            return isRole($roleArray, 'product','product.delete');
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Product $product): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Product $product): bool
    {
        //
    }
}
