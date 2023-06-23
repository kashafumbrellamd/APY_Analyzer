<?php

namespace App\Http\Livewire;

use App\Models\Bank;
use App\Models\Contract;
use App\Models\CustomerBank as CB;
use App\Models\Role;
use App\Models\State;
use App\Models\User;
use Livewire\Component;

class CustomerBank extends Component
{
    public $update = false;
    public $bank_id;
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
    public $report;

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
        $states = State::where('country_id', '233')->get();
        $data = CB::with('contract')->get();
        return view('livewire.customer-bank', ['data' => $data, 'states' => $states]);
    }

    public function submitForm()
    {
        $this->validate();
        $bank = CB::create([
            'bank_name' => $this->bank_name,
            'bank_email' => $this->bank_email,
            'bank_phone_numebr' => $this->bank_phone_numebr,
            'website' => $this->website,
            'msa_code' => $this->msa_code,
            'state' => $this->state,
            'display_reports' => $this->report,
        ]);
        $user = User::create([
            'name' => $this->admin_name,
            'email' => $this->admin_email,
            'phone_number' => $this->admin_phone_number,
            'designation' => $this->designation,
            'employee_id' => $this->employee_id,
            'gender' => $this->gender,
            'password' => bcrypt($this->admin_phone_number),
            'bank_id' => $bank->id,
        ]);
        $contract = Contract::create([
            'contract_start' => $this->contract_start,
            'contract_end' => $this->contract_end,
            'charges' => $this->charges,
            'bank_id' => $bank->id,
        ]);
        $role = Role::where('slug', 'bank-admin')->first();
        $user->roles()->attach($role);
        $this->clear();
        $this->render();
    }

    public function edit($id)
    {
        $bank = CB::with('contract', 'user')->find($id);
        $this->bank_name = $bank->bank_name;
        $this->bank_email = $bank->bank_email;
        $this->bank_phone_numebr = $bank->bank_phone_numebr;
        $this->website = $bank->website;
        $this->msa_code = $bank->msa_code;
        $this->state = $bank->state;
        $this->admin_name = $bank->user->name;
        $this->admin_email = $bank->user->email;
        $this->admin_phone_number = $bank->user->phone_number;
        $this->contract_start = $bank->contract->contract_start;
        $this->contract_end = $bank->contract->contract_end;
        $this->designation = $bank->user->designation;
        $this->employee_id = $bank->user->employee_id;
        $this->gender = $bank->user->gender;
        $this->charges = $bank->contract->charges;
        $this->report = $bank->display_reports;
        $this->update = true;
        $this->bank_id = $id;
        $this->render();
    }

    public function updateForm()
    {
        $this->validate();
        $bank = CB::where('id',$this->bank_id)->update([
            'bank_name' => $this->bank_name,
            'bank_email' => $this->bank_email,
            'bank_phone_numebr' => $this->bank_phone_numebr,
            'website' => $this->website,
            'msa_code' => $this->msa_code,
            'state' => $this->state,
            'display_reports' => $this->report,
        ]);
        $user = User::where('bank_id',$this->bank_id)->update([
            'name' => $this->admin_name,
            'email' => $this->admin_email,
            'phone_number' => $this->admin_phone_number,
            'designation' => $this->designation,
            'employee_id' => $this->employee_id,
            'gender' => $this->gender,
            'password' => bcrypt($this->admin_phone_number),
        ]);
        $contract = Contract::where('bank_id',$this->bank_id)->update([
            'contract_start' => $this->contract_start,
            'contract_end' => $this->contract_end,
            'charges' => $this->charges,
        ]);
        $this->update = false;
        $this->clear();
        $this->render();
    }

    public function clear()
    {
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
        $this->report = '';
    }
}
