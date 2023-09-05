<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Blog;
use App\Models\Brand;
use App\Models\ModulePermission;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Policies\BlogPolicy;
use App\Policies\BrandPolicy;
use App\Policies\ModulePermissionPolicy;
use App\Policies\PermissionPolicy;
use App\Policies\RolePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Brand::class => BrandPolicy::class,
        Blog::class => BlogPolicy::class,
        ModulePermission::class => ModulePermissionPolicy::class,
        Role::class => RolePolicy::class,
        Permission::class => PermissionPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
        $modules = ModulePermission::all();


        if($modules->count()>0){
            foreach ($modules as $module){
                Gate::define($module->name.'.view',function (User $user) use ($module){
                   $userRole = $user->role;
                   $permission = Role::where('name',$userRole)->first();
                    $roleJson = $permission->permission;

                    if(!empty($roleJson)){
                        $roleArray = json_decode($roleJson,true);
                        return isRole($roleArray, $module->name);
                    }
                    return false;
                });

                Gate::define($module->name.'.add',function (User $user) use ($module){
                    $userRole = $user->role;
                    $permission = Role::where('name',$userRole)->first();
                    $roleJson = $permission->permission;
                    if(!empty($roleJson)){
                        $roleArray = json_decode($roleJson,true);
                        return isRole($roleArray, $module->name,'add');
                    }
                    return false;
                });

                Gate::define($module->name.'.edit',function (User $user) use ($module){

                    if ($module->name === 'blog') {

                        //Check permissions case user is 'admin'
                        if($user->role == 'admin'){
                            $userRole = $user->role;
                            $permission = Role::where('name', $userRole)->first();
                            if ($permission) {
                                $roleJson = $permission->permission;
                                if (!empty($roleJson)) {
                                    $roleArray = json_decode($roleJson, true);
                                    return isRole($roleArray, $module->name, 'edit');
                                }
                            }
                        }else{
                            //Check permissions case user is 'author'
                            if ($user->id === $blog->user_id) {
                                return true;
                            } else {
                                return false;
                            }
                        }

                    } else {
                        $userRole = $user->role;
                        $permission = Role::where('name', $userRole)->first();
                        if ($permission) {
                            $roleJson = $permission->permission;
                            if (!empty($roleJson)) {
                                $roleArray = json_decode($roleJson, true);
                                return isRole($roleArray, $module->name, 'edit');
                            }
                        }
                    }


                    return false;
                });

                Gate::define($module->name.'.delete',function (User $user) use ($module){

                    if ($module->name === 'blog') {

                        //Check permissions case user is 'admin'
                        if($user->role == 'admin'){
                            $userRole = $user->role;
                            $permission = Role::where('name', $userRole)->first();
                            if ($permission) {
                                $roleJson = $permission->permission;
                                if (!empty($roleJson)) {
                                    $roleArray = json_decode($roleJson, true);
                                    return isRole($roleArray, $module->name, 'delete');
                                }
                            }
                        }else{
                            //Check permissions case user is 'author'
                            if ($user->id === $blog->user_id) {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    } else {
                        $userRole = $user->role;
                        $permission = Role::where('name',$userRole)->first();
                        $roleJson = $permission->permission;
                        if(!empty($roleJson)){
                            $roleArray = json_decode($roleJson,true);
                            return isRole($roleArray, $module->name,'delete');
                        }
                    }

                    return false;
                });

                Gate::define($module->name.'.permission',function (User $user) use ($module){
                    $userRole = $user->role;
                    $permission = Role::where('name',$userRole)->first();
                    $roleJson = $permission->permission;
                    if(!empty($roleJson)){
                        $roleArray = json_decode($roleJson,true);
                        return isRole($roleArray, $module->name,'permission');
                    }
                    return false;
                });
            }
        }
    }
}
