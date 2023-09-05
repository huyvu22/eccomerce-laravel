<?php

namespace App\Policies;

use App\Models\Blog;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BlogPolicy
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
    public function view(User $user, Blog $blog): bool
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
            return isRole($roleArray, 'blog','blog.add');
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Blog $blog): bool
    {
//        if ($user->id === $blog->user_id) {
//            return true; // User can update their own blog
//        }

        $userRole = $user->role;
        $permission = Role::where('name', $userRole)->first();

        if ($permission) {
            $roleJson = $permission->permission;
            if (!empty($roleJson)) {
                $roleArray = json_decode($roleJson, true);
                return isRole($roleArray, 'blog', 'blog.edit');
            }
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Blog $blog): bool
    {
        $userRole = $user->role;
        $permission = Role::where('name',$userRole)->first();
        $roleJson = $permission->permission;
        if(!empty($roleJson)){
            $roleArray = json_decode($roleJson,true);
            return isRole($roleArray, 'blog','blog.delete');
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Blog $blog): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Blog $blog): bool
    {
        //
    }
}
