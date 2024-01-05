<?php

namespace App\Http\Livewire;

use App\Models\Bank;
use App\Models\Contract;
use App\Models\CustomerBank as CB;
use App\Models\Role;
use App\Models\State;
use App\Models\User;
use App\Models\Cities;
use App\Models\Charity;
use App\Models\Packages;
use App\Models\CustomPackageBanks;
use Livewire\Component;
use Livewire\WithPagination;

class CustomerBank extends Component
{
    use WithPagination;

    public $update = false;
    public $bank_id;
    public $bank_name;
    public $bank_email;
    public $bank_phone_numebr;
    public $website;
    // public $msa_code;
    public $state;
    public $bank_city;
    public $bank_charity = null;

    public $admin_name;
    public $admin_last_name;
    public $admin_email;
    public $admin_phone_number;
    public $contract_start;
    public $contract_end;
    public $designation;
    // public $employee_id;
    // public $gender;
    public $charges;
    // public $report;
    public $subscription;
    public $selected = [];
    public $custom_states = [];
    public $custom_banks = [];
    public $custom_bank_select = '';
    public $selectedbanks = [];

    public $search = '';

    protected $rules = [
        'bank_name' => 'required',
        'bank_email' => 'required',
        'bank_phone_numebr' => 'required',
        'website' => 'required',
        'state' => 'required',
        'bank_city' => 'required',
        'admin_name' => 'required',
        'admin_last_name' => 'required',
        'admin_email' => 'required',
        'admin_phone_number' => 'required',
        'designation' => 'required',
        // 'employee_id' => 'required',
        // 'gender' => 'required',
        // 'charges' => 'required',
        // 'contract_start' => 'required',
        // 'contract_end' => 'required',
    ];

    public function render()
    {
        $states = State::where('country_id', '233')->get();
        $charities = Charity::all();
        if ($this->search == "") {
            $data = CB::with('contract','states')->paginate(10);
        }else{
            $data = CB::with('contract','states')->where('bank_name','like','%'.$this->search.'%')->paginate(10);
        }
        if($this->state != ""){
            $this->bank_cities = Cities::where('state_id',$this->state)->get();
        }else{
            $this->bank_cities = null;
        }
        $packages = Packages::get();
        $bank_states = State::where('country_id', '233')
        ->join('banks','banks.state_id','states.id')
        ->groupby('states.id')
        ->select('states.*')
        ->get();
        return view('livewire.customer-bank', ['data' => $data, 'states' => $states,'packages'=>$packages,'bank_states'=>$bank_states,'charities'=>$charities]);
    }

    public function submitForm()
    {
        $this->validate();
        if($this->subscription == 'custom' && $this->custom_banks == []){
            $this->addError('customer_banks', 'You have to Select atleast 1 bank');
        }else{
            $bank = CB::create([
                'bank_name' => $this->bank_name,
                'bank_email' => $this->bank_email,
                'bank_phone_numebr' => $this->bank_phone_numebr,
                'website' => $this->website,
                'city_id' => $this->bank_city,
                'charity_id' => $this->bank_charity,
                'state' => $this->state,
                'display_reports' => $this->subscription,
            ]);
            $user = User::create([
                'name' => $this->admin_name,
                'last_name' => $this->admin_last_name,
                'email' => $this->admin_email,
                'phone_number' => $this->admin_phone_number,
                'designation' => $this->designation,
                // 'employee_id' => $this->admin_employeeid,
                // 'gender' => $this->admin_gender,
                'password' => bcrypt($this->admin_phone_number),
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
            $this->render();
        }
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
        $this->bank_city = $bank->city_id;
        $this->bank_charity = $bank->charity_id;
        $this->admin_name = $bank->user->name;
        $this->admin_last_name = $bank->user->last_name;
        $this->admin_email = $bank->user->email;
        $this->admin_phone_number = $bank->user->phone_number;
        $this->designation = $bank->user->designation;
        $this->subscription = $bank->display_reports;
        $this->contract_start = $bank->contract->contract_start;
        $this->contract_end = $bank->contract->contract_end;
        $this->charges = $bank->contract->charges;
        // $this->selected = [];
        // $this->custom_states = [];
        // $this->custom_banks = [];
        // $this->custom_bank_select = '';
        // $this->selectedbanks = [];
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
            'city_id' => $this->bank_city,
            'charity_id' => $this->bank_charity,
            'state' => $this->state,
            'display_reports' => $this->subscription,
        ]);
        $user = User::where('bank_id',$this->bank_id)->update([
            'name' => $this->admin_name,
            'last_name' => $this->admin_last_name,
            'email' => $this->admin_email,
            'phone_number' => $this->admin_phone_number,
            'designation' => $this->designation,
            //'employee_id' => $this->employee_id,
            //'gender' => $this->gender,
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
    public function delete($id){
        CB::find($id)->delete();
        $this->render();
    }

    public function clear()
    {
        $this->bank_name = '';
        $this->bank_email = '';
        $this->bank_phone_numebr = '';
        $this->bank_charity = null;
        $this->bank_city = '';
        $this->website = '';
        $this->msa_code = '';
        $this->state = '';
        $this->admin_name = '';
        $this->admin_last_name = '';
        $this->admin_email = '';
        $this->admin_phone_number = '';
        $this->contract_start = '';
        $this->contract_end = '';
        $this->designation = '';
        $this->employee_id = '';
        $this->gender = '';
        $this->charges = '';
        $this->report = '';
        $this->subscription = '';
    }


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

    public function view($id){
        return redirect(url('/view/detailed/customer/bank/'.$id));
    }

    public function search(){
        $this->resetPage();
    }
}
