<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Role;

class PermanentUsers extends Component
{
    public $user_id;
    public $update_role;
    public $update = false;
    public $status;


    public function render()
    {
        $data = User::with('roles')->get();
        $roles = Role::get();
        return view('livewire.permanent-users', ['data'=>$data, 'role'=>$roles]);
    }

    public function edit($id){
        $this->user_id = $id;
        $this->status = User::find($id)->status;
        $this->update_role = User::find($id)->roles()->first()->id;
        $this->update = true;
        $this->render();
    }

    public function update(){
        if($this->update_role!='')
        {
            $user = User::find($this->user_id);
            $user->roles()->detach();

            $role = Role::find($this->update_role);
            $user->roles()->attach($role);
        }

        User::find($this->user_id)->update([
            'status' => $this->status,
        ]);

        $this->cancel();
        $this->render();
    }

    public function cancel(){
        $this->update_role = '';
        $this->update = false;
        $this->user_id = '';
        $this->status = '';
        $this->render();
    }
}
