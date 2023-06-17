<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Permission;
use App\Models\Role;


class RolePermission extends Component
{
    public $role_id = '';

    public function render()
    {
        $permissions = Permission::getPermissionsWithRoles($this->role_id);
        $rolls = Role::all();
        return view('livewire.role-permission',['permissions'=>$permissions,'rolls'=>$rolls]);
    }

    // public function onrollselect($id)
    // {
    //     $permissions = Permission::getPermissionsWithRoles();
    //     $rolls = Role::all();
    //     return view('livewire.role-permission',['permissions'=>$permissions,'rolls'=>$rolls,'roll_id'=>$id]);
    // }
}
