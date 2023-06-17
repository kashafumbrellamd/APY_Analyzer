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
        $permissions = Permission::getPermissionsWithRoles($this->role_id);
        $rolls = Role::all();
        if($this->role_id!='' && $this->selectedOptions==[])
        {
            foreach($permissions as $per)
            {
                if($this->role_id == $per->role_id)
                {
                    array_push($this->selectedOptions,(String)$per->id);
                }
            }
        }
        return view('livewire.role-permission',['permissions'=>$permissions,'rolls'=>$rolls]);
    }

    public function submitForm()
    {
        if($this->role_id != '')
        {
            if($this->selectedOptions == [])
            {
                $role = Role::find($this->role_id);
                $role->permissions()->detach();
            }
            else
            {
                $role = Role::find($this->role_id);
                $role->permissions()->detach();
                foreach($this->selectedOptions as $opt)
                {
                    $permis = Permission::find($opt);
                    $role->permissions()->attach($permis);
                }
            }
        }
    }

    public function onrollselect($id)
    {
        $this->selectedOptions = [];
        $this->role_id = $id;
        $this->render();
        // $permissions = Permission::getPermissionsWithRoles();
        // $rolls = Role::all();
        // return view('livewire.role-permission',['permissions'=>$permissions,'rolls'=>$rolls,'roll_id'=>$id]);
    }
}
