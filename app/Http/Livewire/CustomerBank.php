<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Bank;
use App\Models\State;
use App\Models\CustomerBank as CB;
use App\Models\BankAdmin;

class CustomerBank extends Component
{
    public $bank_name;
    public $bank_email;
    public $bank_phone_numebr;
    public $website;
    public $msa_code;
    public $state;
    public $admin_name;
    public $admin_email;
    public $admin_phone_number;
    public $contract_start;
    public $contract_end;
    public $designation;
    public $employee_id;
    public $gender;
    public $charges;

    protected $rules = [
        'name' => 'required',
        'email' => 'required|email|unique:pending_users',
        'role_id' => 'required',
    ];

    public function render()
    {
        $states = State::where('country_id','233')->get();
        return view('livewire.customer-bank',['states'=>$states]);
    }

    public function submitForm(){
        dd("here");
    }
}
