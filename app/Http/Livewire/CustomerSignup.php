<?php

namespace App\Http\Livewire;

use App\Models\Bank;
use App\Models\Contract;
use App\Models\CustomerBank as CB;
use App\Models\Role;
use App\Models\State;
use App\Models\User;
use Livewire\Component;

class CustomerSignup extends Component
{
    public $bank_name = '';
    public $bank_email = '';
    public $bank_phone = '';
    public $bank_website = '';
    public $bank_msa = '';
    public $bank_state = '';
    public $admin_name = '';
    public $admin_email = '';
    public $admin_phone = '';
    public $admin_designation = '';
    public $admin_employeeid = '';
    public $admin_gender = '';
    public $subscription = '';
    public $custom_states = [];
    public $custom_banks = [];
    public $custom_bank_select = '';

    protected $rules = [
        'bank_name' => 'required',
        'bank_email' => 'required',
        'bank_phone' => 'required',
        'bank_website' => 'required',
        'bank_msa' => 'required',
        'bank_state' => 'required',
        'admin_name' => 'required',
        'admin_email' => 'required',
        'admin_phone' => 'required',
        'admin_designation' => 'required',
        'admin_employeeid' => 'required',
        'admin_gender' => 'required',
        'subscription' => 'required',
    ];

    public function render()
    {
        $states = State::where('country_id', '233')->get();
        return view('livewire.customer-signup', ['states' => $states]);
    }

    public function submitForm()
    {
        $this->validate();
        $bank = CB::create([
            'bank_name' => $this->bank_name,
            'bank_email' => $this->bank_email,
            'bank_phone_numebr' => $this->bank_phone,
            'website' => $this->bank_website,
            'msa_code' => $this->bank_msa,
            'state' => $this->bank_state,
            'display_reports' => $this->subscription,
        ]);
        $user = User::create([
            'name' => $this->admin_name,
            'email' => $this->admin_email,
            'phone_number' => $this->admin_phone,
            'designation' => $this->admin_designation,
            'employee_id' => $this->admin_employeeid,
            'gender' => $this->admin_gender,
            'password' => bcrypt($this->admin_phone),
            'bank_id' => $bank->id,
        ]);
        $charges = 125;
        if($this->subscription == 'custom'){
            $charges = 500;
        }elseif ($this->subscription == 'state') {
            $charges = 250;
        }
        $contract = Contract::create([
            'contract_start' => date('Y-m-d'),
            'contract_end' => date('Y-m-d', strtotime(date('Y-m-d'). ' + 1 year')),
            'charges' => $charges,
            'bank_id' => $bank->id,
        ]);
        $role = Role::where('slug', 'bank-admin')->first();
        $user->roles()->attach($role);
        $this->clear();
        return redirect(url('/'));
        $this->render();
    }

    public function selectlist()
    {
        $this->custom_bank_select = Bank::whereIn('state_id',$this->custom_states)->get();
    }

    public function clear()
    {
        $this->bank_name = '';
        $this->bank_email = '';
        $this->bank_phone = '';
        $this->bank_website = '';
        $this->bank_msa = '';
        $this->bank_state = '';
        $this->admin_name = '';
        $this->admin_email = '';
        $this->admin_phone = '';
        $this->admin_designation = '';
        $this->admin_employeeid = '';
        $this->admin_gender = '';
        $this->subscription = '';
    }
}
