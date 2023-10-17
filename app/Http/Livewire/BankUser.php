<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Bank;
use App\Models\CustomerBank;
use App\Models\User;
use App\Models\State;
use App\Models\Role;

class BankUser extends Component
{
    public $first_admin_name;
    public $last_admin_name;
    public $admin_email;
    public $admin_phone_number;
    public $designation;
    public $employee_id;
    public $gender;

    protected $rules = [
        'first_admin_name' => 'required',
        'last_admin_name' => 'required',
        'admin_email' => 'required',
        'admin_phone_number' => 'required',
        'designation' => 'required',
    ];

    public function render()
    {
        $data = User::with('banks')->where('bank_id', auth()->user()->bank_id)->where('id','!=',auth()->user()->id)->get();
        $banks = CustomerBank::get();
        return view('livewire.bank-user',['data'=>$data,'banks'=>$banks]);
    }

    public function submitForm(){
        $this->validate();
        $check = User::where('email',$this->admin_email)->first();
        if($check == null){
            $user = User::create([
                'name' => $this->first_admin_name,
                'last_name' => $this->last_admin_name,
                'email' => $this->admin_email,
                'phone_number' => $this->admin_phone_number,
                'designation' => $this->designation,
                'employee_id' => $this->employee_id,
                'gender' => $this->gender,
                'bank_id' => auth()->user()->bank_id,
                'password' => bcrypt($this->admin_phone_number),
                'status' => "1",
            ]);
            $role = Role::where('slug','bank-user')->first();
            $user->roles()->attach($role);
            $this->clear();
        }else{
            $this->addError('error','User with this Email Address already exists');
        }
        $this->render();

    }

    public function delete($id){
        User::find($id)->delete();
        $this->render();
    }

    public function clear(){
        $this->first_admin_name = '';
        $this->last_admin_name = '';
        $this->admin_email = '';
        $this->admin_phone_number = '';
        $this->designation = '';
        $this->employee_id = '';
        $this->gender = '';
        $this->bank_id = '';
    }
}
