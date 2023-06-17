<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Permission;
use App\Models\Role;


class RolePermission extends Component
{
    public $role_id = '';
    public $selectedOptions = [];

    public function render()
    {
        $this->selectedOptions = [];
        $permissions = Permission::getPermissionsWithRoles($this->role_id);
        $rolls = Role::all();
        if($this->role_id!='')
        {
            foreach($permissions as $per)
            {
                if($this->role_id == $per->role_id)
                {
                    array_push($this->selectedOptions,$per->id);
                }
            }
        }
        return view('livewire.role-permission',['permissions'=>$permissions,'rolls'=>$rolls]);
    }

    public function submitForm()
    {
        dd($this->selectedOptions,$this->role_id);
    }

    // public function onrollselect($id)
    // {
    //     $permissions = Permission::getPermissionsWithRoles();
    //     $rolls = Role::all();
    //     return view('livewire.role-permission',['permissions'=>$permissions,'rolls'=>$rolls,'roll_id'=>$id]);
    // }
}
