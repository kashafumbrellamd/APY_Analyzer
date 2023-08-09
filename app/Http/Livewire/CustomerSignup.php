<?php

namespace App\Http\Livewire;

use App\Models\Bank;
use App\Models\BankType;
use App\Models\Contract;
use App\Models\CustomerBank as CB;
use App\Models\Role;
use App\Models\State;
use App\Models\User;
use App\Models\Packages;
use App\Models\CustomPackageBanks;
use App\Models\Cities;
use App\Models\Charity;
use App\Models\Zip_code;
use Livewire\Component;
use Str;

class CustomerSignup extends Component
{
    public $bank_name = '';
    public $bank_email = '';
    public $bank_phone = '';
    public $bank_website = '';
    public $bank_msa = '';
    public $cbsa_code = '';
    public $zip_code = '';
    public $bank_state = '';
    public $bank_city = '';
    public $bank_charity = null;

    public $admin_first_name = '';
    public $admin_last_name = '';
    public $admin_email = '';
    public $admin_phone = '';
    public $admin_designation = '';
    public $admin_employeeid = '';
    public $admin_gender = '';

    public $subscription = '';
    public $custom_banks = [];
    public $selectedbanks = [];

    public $all_banks = null;
    public $bank_search = '';
    public $bank_type = '';

    protected $rules = [
        'bank_name' => 'required',
        'bank_email' => 'required',
        'bank_phone' => 'required',
        'bank_website' => 'required',
        // 'bank_msa' => 'required',
        'bank_state' => 'required',
        'bank_city' => 'required',
        'bank_state' => 'required',
        'admin_first_name' => 'required',
        'admin_last_name' => 'required',
        'admin_email' => 'required',
        'admin_phone' => 'required',
        'admin_designation' => 'required',
        // 'admin_employeeid' => 'required',
        // 'admin_gender' => 'required',
        'subscription' => 'required',
    ];
    protected $listeners = [
        'selected'
     ];

    public function render()
    {
        $states = State::where('country_id', '233')->get();
        $charities = Charity::all();
        if(strlen($this->bank_search) > 0){
            $this->search_bank($this->bank_search,$this->bank_type);
        }else{
            $this->search_bank('',$this->bank_type);
        }
        $bank_cities = Cities::get();
        $packages = Packages::get();
        $bank_types = BankType::where('status',1)->get();
        return view('livewire.customer-signup', ['states'=>$states,'packages'=>$packages,'bank_cities'=>$bank_cities,'charities'=>$charities,'bank_types'=>$bank_types]);
    }

    public function submitForm()
    {
        if($this->subscription == 'custom' && $this->custom_banks == []){
            $this->addError('customer_banks', 'You have to Select atleast 1 bank');
        }else{
            $bank = CB::create([
            'bank_name' => $this->bank_name,
            'bank_email' => $this->bank_email,
            'bank_phone_numebr' => $this->bank_phone,
            'website' => $this->bank_website,
            'city_id' => $this->bank_city,
            'charity_id' => $this->bank_charity,
            'state' => $this->bank_state,
            'zip_code' => $this->zip_code,
            'cbsa_code' => $this->cbsa_code,
            'display_reports' => $this->subscription,
            ]);
            $user = User::create([
                'name' => $this->admin_first_name,
                'last_name' => $this->admin_last_name,
                'email' => $this->admin_email,
                'phone_number' => $this->admin_phone,
                'designation' => $this->admin_designation,
                // 'employee_id' => $this->admin_employeeid,
                // 'gender' => $this->admin_gender,
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
        $this->bank_charity = null;
        $this->zip_code = '';
        $this->cbsa_code = '';
        $this->admin_first_name = '';
        $this->admin_email = '';
        $this->admin_phone = '';
        $this->admin_designation = '';
        $this->admin_employeeid = '';
        $this->admin_gender = '';
        $this->subscription = '';
        $this->custom_banks = [];
        $this->selectedbanks = [];
        $this->all_banks = null;
        $this->bank_search = '';
        $this->bank_type = '';
    }

    public function search_bank($value,$type)
    {
        if($value != '' && $type != '') {
            $All_banks = Bank::join('states','banks.state_id','states.id')
            ->join('cities','banks.city_id','cities.id')
            ->where('banks.name',$value)
            ->orwhere('states.name',$value)
            ->orwhere('cities.name',$value)
            ->orwhere('states.state_code',$value)
            ->where('banks.bank_type_id',$type)
            ->select('banks.*','states.name as state_name','cities.name as city_name')
            ->get();
            $this->all_banks = $All_banks;
        }elseif ($value != '' && $type == '') {
            $All_banks = Bank::join('states','banks.state_id','states.id')
            ->join('cities','banks.city_id','cities.id')
            ->join('bank_types','banks.bank_type_id','bank_types.id')
            ->where('bank_types.status',1)
            ->where('banks.name',$value)
            ->orwhere('states.name',$value)
            ->orwhere('cities.name',$value)
            ->orwhere('states.state_code',$value)
            ->select('banks.*','states.name as state_name','cities.name as city_name')
            ->get();
            $this->all_banks = $All_banks;
        }elseif ($value == '' && $type != '') {
            $All_banks = Bank::join('states','banks.state_id','states.id')
            ->join('cities','banks.city_id','cities.id')
            ->where('banks.bank_type_id',$type)
            ->select('banks.*','states.name as state_name','cities.name as city_name')
            ->get();
            $this->all_banks = $All_banks;
        }else {
            $All_banks = Bank::join('states','banks.state_id','states.id')
            ->join('cities','banks.city_id','cities.id')
            ->join('bank_types','banks.bank_type_id','bank_types.id')
            ->where('bank_types.status',1)
            ->select('banks.*','states.name as state_name','cities.name as city_name')
            ->get();
            $this->all_banks = $All_banks;
        }
    }

    public function select_bank($id)
    {
        if(in_array($id,$this->custom_banks)){
            unset($this->custom_banks[array_search($id,$this->custom_banks)]);
        }else{
            array_push($this->custom_banks,$id);
        }
        foreach($this->all_banks as $bank)
        {
            array_push($this->selectedbanks,$bank->id);
        }
        $All_banks = Bank::whereIn('banks.id',$this->selectedbanks)
        ->join('states','banks.state_id','states.id')
        ->join('cities','banks.city_id','cities.id')
        ->select('banks.*','states.name as state_name','cities.name as city_name')
        ->get();
        $this->all_banks = $All_banks;
        $this->selectedbanks = [];
    }

    public function select_all_banks()
    {
        foreach($this->all_banks as $bank)
        {
            if(!in_array($bank->id,$this->custom_banks)){
                array_push($this->custom_banks,$bank->id);
            }
            array_push($this->selectedbanks,$bank->id);
        }
        $All_banks = Bank::whereIn('banks.id',$this->selectedbanks)
        ->join('states','banks.state_id','states.id')
        ->join('cities','banks.city_id','cities.id')
        ->select('banks.*','states.name as state_name','cities.name as city_name')
        ->get();
        $this->all_banks = $All_banks;
        $this->selectedbanks = [];
    }

    public function deselect_all_banks()
    {
        foreach($this->all_banks as $bank)
        {
            if(in_array($bank->id,$this->custom_banks)){
                unset($this->custom_banks[array_search($bank->id,$this->custom_banks)]);
            }
            array_push($this->selectedbanks,$bank->id);
        }
        $All_banks = Bank::whereIn('banks.id',$this->selectedbanks)
        ->join('states','banks.state_id','states.id')
        ->join('cities','banks.city_id','cities.id')
        ->select('banks.*','states.name as state_name','cities.name as city_name')
        ->get();
        $this->all_banks = $All_banks;
        $this->selectedbanks = [];
    }

    public function fetch_zip_code(){
        if (Str::length($this->zip_code) >= 5) {
            $zip = Zip_code::where('zip_code',$this->zip_code)->first();
            if ($zip != null) {
                $this->bank_city = Cities::where('name',$zip->city)->pluck('id')->first();
                $this->bank_state = State::where('name',$zip->state)->pluck('id')->first();
            }
        }else{
            $this->bank_city = "";
            $this->bank_state = "";
        }
    }
}
