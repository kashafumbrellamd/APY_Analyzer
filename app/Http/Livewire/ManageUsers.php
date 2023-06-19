<?php

namespace App\Http\Livewire;

use App\Models\PendingUsers;
use App\Models\Role;
use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserEmailVerification;

class ManageUsers extends Component
{
    public $name;
    public $email;
    public $role_id;

    protected $rules = [
        'name' => 'required',
        'email' => 'required|email|unique:pending_users',
        'role_id' => 'required',
    ];

    public function render()
    {
        $data = PendingUsers::with('role')->get();
        $roles = Role::all();
        return view('livewire.manage-users', ['data'=>$data,'roles' => $roles]);
    }

    public function submitForm()
    {
        $this->validate();
        $code = rand(111111, 999999);
        $p_user = PendingUsers::create([
            'name' => $this->name,
            'email' => $this->email,
            'role_id' => $this->role_id,
            'verification_code' => $code,
        ]);

        Mail::to($this->email)->send(new UserEmailVerification($p_user));

        $this->clear();
        $this->render();
    }

    public function delete($id){
        PendingUsers::find($id)->delete();
        $this->render();
    }

    public function clear()
    {
        $this->name = '';
        $this->email = '';
        $this->role_id = '';
    }
}
