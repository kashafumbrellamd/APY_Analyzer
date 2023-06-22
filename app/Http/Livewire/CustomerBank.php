<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Bank;
use App\Models\State;
use App\Models\CustomerBank as CB;
use App\Models\BankAdmin;
use App\Models\Contract;

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
        'bank_name' => 'required',
        'bank_email' => 'required',
        'bank_phone_numebr' => 'required',
        'website' => 'required',
        'msa_code' => 'required',
        'state' => 'required',
        'admin_name' => 'required',
        'admin_email' => 'required',
        'admin_phone_number' => 'required',
        'designation' => 'required',
        'employee_id' => 'required',
        'gender' => 'required',
        'charges' => 'required',
        'contract_start' => 'required',
        'contract_end' => 'required',
    ];

    public function render()
    {
        $states = State::where('country_id','233')->get();
        $data = CB::with('contract')->get();
        return view('livewire.customer-bank',['data'=>$data,'states'=>$states]);
    }

    public function submitForm(){
        $this->validate();
        $bank = CB::create([
            'bank_name' => $this->bank_name,
            'bank_email' => $this->bank_email,
            'bank_phone_numebr' => $this->bank_phone_numebr,
            'website' => $this->website,
            'msa_code' => $this->msa_code,
            'state' => $this->state,
        ]);
        $admin = BankAdmin::create([
            'name' => $this->admin_name,
            'email' => $this->admin_email,
            'phone_number' => $this->admin_phone_number,
            'designation' => $this->designation,
            'employee_id' => $this->employee_id,
            'gender' => $this->gender,
            'bank_id' => $bank->id,
        ]);
        $contract = Contract::create([
            'contract_start' => $this->contract_start,
            'contract_end' => $this->contract_end,
            'charges' => $this->charges,
            'bank_id' => $bank->id,
        ]);
        $this->clear();
        $this->render();
    }

    public function clear(){
        $this->bank_name = '';
        $this->bank_email = '';
        $this->bank_phone_numebr = '';
        $this->website = '';
        $this->msa_code = '';
        $this->state = '';
        $this->admin_name = '';
        $this->admin_email = '';
        $this->admin_phone_number = '';
        $this->contract_start = '';
        $this->contract_end = '';
        $this->designation = '';
        $this->employee_id = '';
        $this->gender = '';
        $this->charges = '';
    }
}
