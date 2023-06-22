<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Bank;
use App\Models\CustomerBank;
use App\Models\BankAdmin;
use App\Models\State;

class CustomerBankAdmin extends Component
{
    public $admin_name;
    public $admin_email;
    public $admin_phone_number;
    public $designation;
    public $employee_id;
    public $gender;
    public $bank_id;

    protected $rules = [
        'bank_id' => 'required',
        'admin_name' => 'required',
        'admin_email' => 'required',
        'admin_phone_number' => 'required',
        'designation' => 'required',
        'employee_id' => 'required',
        'gender' => 'required',
    ];

    public function render()
    {
        $states = State::where('country_id','233')->get();
        $data = BankAdmin::with('customer_bank')->get();
        $banks = CustomerBank::get();
        return view('livewire.customer-bank-admin', ['data'=>$data,'states'=>$states,'banks'=>$banks]);
    }

    public function submitForm(){
        $this->validate();
        $user = BankAdmin::where('bank_id',$this->bank_id)->first();
        if($user == null){
            $admin = BankAdmin::create([
                'name' => $this->admin_name,
                'email' => $this->admin_email,
                'phone_number' => $this->admin_phone_number,
                'designation' => $this->designation,
                'employee_id' => $this->employee_id,
                'gender' => $this->gender,
                'bank_id' => $this->bank_id,
            ]);
        }else{
            $this->addError('error','This Bank Already has an Admin');
        }

        $this->clear();
        $this->render();
    }

    public function delete($id){
        BankAdmin::find($id)->delete();
        $this->render();
    }

    public function clear(){
        $this->admin_name = '';
        $this->admin_email = '';
        $this->admin_phone_number = '';
        $this->designation = '';
        $this->employee_id = '';
        $this->gender = '';
        $this->bank_id = '';
    }
}
