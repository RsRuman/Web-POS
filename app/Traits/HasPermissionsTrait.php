<?php
/*
* Author: Arup Kumer Bose
* Email: arupkumerbose@gmail.com
* Company Name: Brainchild Software <brainchildsoft@gmail.com>
*/
namespace App\Traits;

use App\Models\Permission;
use App\Models\Role;

trait HasPermissionsTrait
{
    #Give permission to user
    public function givePermissionsTo(...$permissions){
        $permissions = $this->getAllPermissions($permissions);
        if ($permissions === null){
            return $this;
        }
        $this->permissions()->saveMany($permissions);
        return $this;
    }

    #Remove permissions from user
    public function withdrawPermissionsTo(...$permissions){
        $permissions = $this->getAllPermissions($permissions);
        $this->permissions()->detach($permissions);
        return $this;
    }

    #Refreshing permissions
    public function refreshPermissions(...$permissions){
        $this->permissions()->detach();
        return $this->givePermissionsTo($permissions);
    }

    #Checking user has permission to
    public function hasPermissionTo($permission){
        return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission);
    }

    #Checking this role user has permission
    public function hasPermissionThroughRole($permission){
        foreach ($permission->roles as $role){
            if ($this->roles->contains($role)){
                return true;
            }
        }
        return false;
    }

    #Checking user has role
    public function hasRole(...$roles){
        foreach ($roles as $role){
            if ($this->roles->contains('slug', $role)){
                return true;
            }
        }
        return false;
    }

    #Checking user has permission
    public function hasPermission($permission){
        return (bool) $this->permissions->where('slug', $permission->slug)->count();
    }

    #Defining this model and role model
    public function roles() {

        return $this->belongsToMany(Role::class,'user_roles');

    }

    #Defining this model and permission model
    public function permissions() {

        return $this->belongsToMany(Permission::class,'user_permissions');

    }

    #Get all permissions
    protected function getAllPermissions(array $permissions)
    {
        return Permission::whereIn('slug', $permissions)->get();
    }
}
