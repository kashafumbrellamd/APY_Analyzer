<?php

namespace App\Http\Livewire;

use App\Models\Bank;
use App\Models\Contract;
use App\Models\CustomerBank as CB;
use App\Models\Role;
use App\Models\State;
use App\Models\User;
use App\Models\Packages;
use App\Models\CustomPackageBanks;
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
    public $selectedbanks = [];
    public $selected = [];
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
    protected $listeners = [
        'selected'
     ];

    public function render()
    {
        $states = State::where('country_id', '233')->get();
        $bank_states = State::where('country_id', '233')
        ->join('banks','banks.state_id','states.id')
        ->groupby('states.id')
        ->select('states.*')
        ->get();
        $packages = Packages::get();
        return view('livewire.customer-signup', ['states' => $states,'packages'=>$packages,'bank_states'=>$bank_states]);
    }

    public function submitForm()
    {
        if($this->subscription == 'custom' && $this->custom_banks != []){
            $this->addError('customer_banks', 'You have to Select atleast 1 bank');
        }else{
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
            if($this->subscription == 'custom'){
                foreach($this->custom_banks as $key => $custom_bank) {
                    $custom_selected_banks = CustomPackageBanks::create([
                        'bank_id' => $bank->id,
                        'customer_selected_bank_id' => $custom_bank,
                    ]);
                }
            }
            $charges = Packages::where('package_type',$this->subscription)->first();
            $contract = Contract::create([
                'contract_start' => date('Y-m-d'),
                'contract_end' => date('Y-m-d', strtotime(date('Y-m-d'). ' + 1 year')),
                'charges' => $charges->price,
                'bank_id' => $bank->id,
            ]);
            $role = Role::where('slug', 'bank-admin')->first();
            $user->roles()->attach($role);
            $this->clear();
            return redirect(url('/signin'));
        }
        $this->render();
    }

    // public function selectlist()
    // {
    //     $this->custom_bank_select = Bank::whereIn('state_id',$this->custom_states)->get();
    // }

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
    // public function selected($value)
    // {
    //     $this->custom_states = $value;
    //     $this->selectlist();
    // }

    public function addArray($item){
        if($item != ""){
            $state = State::where('id',$item)->first();
            if(!in_array($item,$this->custom_states)){
                array_push($this->custom_states,$item);
                array_push($this->selected,$state->name);
            }else{
                unset($this->custom_states[array_search($item,$this->custom_states)]);
                unset($this->selected[array_search($state->name,$this->selected)]);
            }
            $this->custom_bank_select = Bank::whereIn('state_id',$this->custom_states)->get();
        }
    }

    public function addBanks($item){
        if($item != ""){
            $bank = Bank::where('id',$item)->first();
            if(!in_array($item,$this->custom_banks)){
                array_push($this->custom_banks,$item);
                array_push($this->selectedbanks,$bank->name);
            }else{
                unset($this->custom_banks[array_search($item,$this->custom_banks)]);
                unset($this->selectedbanks[array_search($bank->name,$this->selectedbanks)]);
            }
        }
    }

    public function deleteState($item){
        $state = State::where('name',$this->selected[$item])->first();
        unset($this->custom_states[array_search($state->id,$this->custom_states)]);
        unset($this->selected[$item]);
        $this->custom_bank_select = Bank::whereIn('state_id',$this->custom_states)->get();
    }

    public function deleteBank($item){
        $bank = Bank::where('name',$this->selectedbanks[$item])->first();
        unset($this->custom_banks[array_search($bank->id,$this->custom_banks)]);
        unset($this->selectedbanks[$item]);
    }
}
