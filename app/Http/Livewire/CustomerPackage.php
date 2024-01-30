<?php

namespace App\Http\Livewire;

use App\Models\Bank;
use App\Models\BankType;
use App\Models\Cities;
use App\Models\Packages;
use App\Models\State;
use App\Models\CustomerBank;
use App\Models\CustomPackageBanks;
use App\Models\Contract;
use App\Models\Role;
use App\Models\User;
use App\Models\BankRequest;
use App\Models\BankSelectedCity;
use DB;
use Auth;
use Livewire\Component;
use App\Models\StandardReportList;


class CustomerPackage extends Component
{
    public $bank = '';
    public $custom_banks = [];
    public $selectedbanks = [];

    public $all_banks = null;
    public $bank_search = '';
    public $bank_type = '';

    public $bank_state_filter = [];
    public $bank_state_filter_name = [];

    public $bank_city_filter = [];
    public $bank_city_filter_name = [];

    public $bank_cbsa_filter = [];
    public $bank_cbsa_filter_name = [];

    public $bank_zip_code = "";

    public $selected_banks_name = [];

    public $selected_state_now = '';
    public $selected_city_now = '';
    public $selected_cbsa_now = '';

    public $subscription = '';
    public $selected_package = [];

    public $state_state;

    public $current_amount;
    public $page = 1;
    public $update = true;
    public $standard_report_list;

    public $selectedItems = [];

    public function mount($id)
    {
        $this->bank = CustomerBank::findOrFail($id);
    }
    public function render()
    {
        $newData = $this->fetch_banks($this->page);
        if($this->all_banks != null){
            if($this->update){
                $this->all_banks = $this->all_banks->concat($newData);
                $this->update = false;
            }
        }else{
            $this->all_banks = $newData;
            $this->update = false;
        }
        $packages = Packages::get();
        $this->selected_package = Packages::where('package_type',$this->subscription)->first();
        $bank_types = BankType::where('status', 1)->get();
        $available_states = $this->getStates();
        $available_cities = $this->getCities();
        $available_cbsa = $this->getCBSA();
        $this->current_amount = $this->calulate_current_amount();
        $this->standard_report_list = StandardReportList::where('status','1')->get();
        return view('livewire.customer-package', compact('packages', 'bank_types', 'available_states', 'available_cities','available_cbsa'));
    }

    public function fetch_banks($page)
    {
        $query = Bank::with('states','cities')
                ->join('bank_types', 'banks.bank_type_id', 'bank_types.id')
                ->where('bank_types.status', 1)
                ->orderBy('banks.name')
                ->select('banks.*');

        if (!empty($this->bank_type)) {
            $query->where('banks.bank_type_id', $this->bank_type);
        }

        if (!empty($this->bank_state_filter)) {
            $query->whereIn('banks.state_id', $this->bank_state_filter);
        }

        if (!empty($this->bank_city_filter)) {
            $query->whereIn('banks.city_id', $this->bank_city_filter);
        }

        if (!empty($this->bank_cbsa_filter)) {
            $query->whereIn('banks.cbsa_code', $this->bank_cbsa_filter);
        }

        if (!empty($this->bank_zip_code)) {
            $query->where('banks.zip_code', $this->bank_zip_code);
        }

        return $query->skip(($page-1)*50)->take(50)->get();
        // return $query->paginate(10)->items();
    }

    public function selectbanktype($id)
    {
        $this->page = 1;
        $this->all_banks = null;
        $this->bank_state_filter = [];
        $this->bank_state_filter_name = [];
        $this->bank_city_filter = [];
        $this->bank_city_filter_name = [];
        $this->bank_cbsa_filter = [];
        $this->bank_cbsa_filter_name = [];
    }

    public function subscription_changed($value)
    {
        $this->page = 1;
        $this->subscription = $value;
        $this->all_banks = null;
        $this->bank_state_filter = [];
        $this->bank_state_filter_name = [];
        $this->bank_city_filter = [];
        $this->bank_city_filter_name = [];
        $this->bank_cbsa_filter = [];
        $this->bank_cbsa_filter_name = [];
        $this->resetErrorBag();
    }

    public function getStates()
    {
        $state = DB::table('banks')
            ->join('states', 'states.id', 'banks.state_id')
            ->select('states.id', 'states.name')
            ->groupBy('state_id')
            ->orderBy('states.name');

        if(!empty($this->bank_type)) {
            $state->where('banks.bank_type_id', $this->bank_type);
        }
        return $state->get();
    }

    public function getCities()
    {
        $query = Bank::with('cities')->groupBy('city_id');

        if (!empty($this->bank_type)) {
            $query->where('bank_type_id', $this->bank_type);
        }

        if (!empty($this->bank_state_filter) && $this->bank_state_filter !== 'all') {
            $query->whereIn('state_id', $this->bank_state_filter);
        }
        return $query->get();
    }

    public function getCBSA()
    {
        $query = Bank::groupBy('cbsa_code')->where('cbsa_name','!=','');

        if (!empty($this->bank_type)) {
            $query->where('bank_type_id', $this->bank_type);
        }

        if (!empty($this->bank_state_filter) && $this->bank_state_filter !== 'all') {
            $query->whereIn('state_id', $this->bank_state_filter);
        }

        if (empty($this->bank_type) && (empty($this->bank_state_filter) || $this->bank_state_filter === 'all')) {
            $query->select('cbsa_code', 'cbsa_name');
        }

        return $query->get();
    }

    public function selectstate($id)
    {
        if ($id == "all") {
            $this->bank_state_filter = [];
            $this->bank_state_filter_name = [];
        } else {
            if (!in_array($id, $this->bank_state_filter)) {
                array_push($this->bank_state_filter, $id);
                array_push($this->bank_state_filter_name, State::find($id)->name);
            }
        }
        $this->page = 1;
        $this->all_banks = null;
        $this->selected_state_now = '';
        $this->bank_city_filter = [];
        $this->bank_city_filter_name = [];
        $this->bank_cbsa_filter = [];
        $this->bank_cbsa_filter_name = [];
        $this->bank_zip_code = "";
    }

    public function selectcity($id)
    {
        if ($id == "all") {
            $this->bank_city_filter = [];
            $this->bank_city_filter_name = [];
        } else {
            if (!in_array($id, $this->bank_city_filter)) {
                array_push($this->bank_city_filter, $id);
                array_push($this->bank_city_filter_name, Bank::where('cbsa_code',$id)->pluck('cbsa_name')->first());
            }
        }
        $this->page = 1;
        $this->all_banks = null;
        $this->selected_city_now = '';
        $this->bank_cbsa_filter = [];
        $this->bank_cbsa_filter_name = [];
    }

    public function selectcbsa($id)
    {
        if ($id == "all") {
            $this->bank_cbsa_filter = [];
            $this->bank_cbsa_filter_name = [];
        } else {
            if (!in_array($id, $this->bank_cbsa_filter)) {
                array_push($this->bank_cbsa_filter, $id);
                $cbsssa_name = Bank::where('cbsa_code',$id)->where('cbsa_name','!=','')->select('cbsa_name')->first();
                array_push($this->bank_cbsa_filter_name, $cbsssa_name->cbsa_name);
            }
        }
        $this->page = 1;
        $this->all_banks = null;
        $this->selected_city_now = '';
    }

    // public function select_all_banks()
    // {
    //     foreach ($this->all_banks as $bank) {
    //         if (!in_array($bank->id, $this->custom_banks)) {
    //             array_push($this->custom_banks, $bank->id);
    //         }
    //         array_push($this->selectedbanks, $bank->id);
    //     }
    //     $All_banks = Bank::whereIn('banks.id', $this->selectedbanks)
    //         ->join('states', 'banks.state_id', 'states.id')
    //         ->join('cities', 'banks.city_id', 'cities.id')
    //         ->select('banks.*', 'states.name as state_name', 'cities.name as city_name')
    //         ->get();
    //     $this->all_banks = $All_banks;
    //     $this->selectedbanks = [];
    // }

    // public function deselect_all_banks()
    // {
    //     foreach ($this->all_banks as $bank) {
    //         if (in_array($bank->id, $this->custom_banks)) {
    //             unset($this->custom_banks[array_search($bank->id, $this->custom_banks)]);
    //         }
    //         array_push($this->selectedbanks, $bank->id);
    //     }
    //     $All_banks = Bank::whereIn('banks.id', $this->selectedbanks)
    //         ->join('states', 'banks.state_id', 'states.id')
    //         ->join('cities', 'banks.city_id', 'cities.id')
    //         ->select('banks.*', 'states.name as state_name', 'cities.name as city_name')
    //         ->get();
    //     $this->all_banks = $All_banks;
    //     $this->selectedbanks = [];
    // }

    public function select_bank($id)
    {
        if (in_array($id, $this->custom_banks)) {
            unset($this->custom_banks[array_search($id, $this->custom_banks)]);
            $bank_name_now = Bank::with('states','cities')->where('id',$id)->first()->toArray();
            foreach ($this->selected_banks_name as $index => $item) {
                if ($item['name'] == $bank_name_now['name']) {
                    $key = $index;
                    break;
                }
            }
            unset($this->selected_banks_name[$key]);
            $this->selected_banks_name = array_values($this->selected_banks_name);
        } else {
            array_push($this->custom_banks, $id);
            $bank_name_now = Bank::with('states','cities')->where('id',$id)->first()->toArray();
            array_push($this->selected_banks_name,$bank_name_now);
            usort($this->selected_banks_name, function($a, $b) {
                return strcmp($a["name"], $b["name"]);
            });
        }
        foreach ($this->all_banks as $bank) {
            array_push($this->selectedbanks, $bank->id);
        }
        // $All_banks = Bank::with('states','cities')
        //     ->whereIn('banks.id', $this->selectedbanks)
        //     // ->join('states', 'banks.state_id', 'states.id')
        //     // ->join('cities', 'banks.city_id', 'cities.id')
        //     ->select('banks.*')
        //     ->get();
        //     if($this->update){
        //         $this->all_banks = $All_banks;
        //         $this->selectedbanks = [];
        //     }
    }

    public function save_banks(){
        // dd($this->selectedItems);
        $this->custom_banks = [];
        $this->selected_banks_name = [];
        foreach($this->selectedItems as $id){
            if (in_array($id, $this->custom_banks)) {
                unset($this->custom_banks[array_search($id, $this->custom_banks)]);
                $bank_name_now = Bank::with('states','cities')->where('id',$id)->first()->toArray();
                foreach ($this->selected_banks_name as $index => $item) {
                    if ($item['name'] == $bank_name_now['name']) {
                        $key = $index;
                        break;
                    }
                }
                unset($this->selected_banks_name[$key]);
                $this->selected_banks_name = array_values($this->selected_banks_name);
            } else {
                array_push($this->custom_banks, $id);
                $bank_name_now = Bank::with('states','cities')->where('id',$id)->first()->toArray();
                array_push($this->selected_banks_name,$bank_name_now);
                usort($this->selected_banks_name, function($a, $b) {
                    return strcmp($a["name"], $b["name"]);
                });
            }
            foreach ($this->all_banks as $bank) {
                array_push($this->selectedbanks, $bank->id);
            }
        }
    }

    public function submitForm()
    {
        if($this->subscription != ""){
            if ($this->subscription == 'custom') {
                if(count($this->custom_banks) != 0){
                    foreach ($this->custom_banks as $key => $custom_bank) {
                        $check = Bank::find($custom_bank);
                        if($check->surveyed == "0"){
                            $user = User::where('bank_id',$this->bank->id)->first();
                            BankRequest::create([
                                'name' => $check->name,
                                'zip_code' => $check->zip_code,
                                'state_id' => $check->state_id,
                                'city_id' => $check->city_id,
                                'description' => null,
                                'user_id' => $user->id,
                                'email' => null,
                                'phone_number' => null,
                            ]);
                        }
                        $custom_selected_banks = CustomPackageBanks::create([
                            'bank_id' => $this->bank->id,
                            'customer_selected_bank_id' => $custom_bank,
                        ]);
                    }
                    $charges = Packages::where('package_type', $this->subscription)->first();
                    if(count($this->custom_banks) <= $charges->number_of_units){
                        $contract = Contract::create([
                            'contract_start' => date('Y-m-d', strtotime(date('Y-m-d') . ' + 2 weeks ')),
                            'contract_end' => date('Y-m-d', strtotime(date('Y-m-d') . ' + 1 year + 2 weeks')),
                            'charges' => $charges->price,
                            'bank_id' => $this->bank->id,
                        ]);
                    }else{
                        $amount_charged = $charges->price + ($charges->additional_price*(count($this->custom_banks)-$charges->number_of_units));
                        $contract = Contract::create([
                            'contract_start' => date('Y-m-d', strtotime(date('Y-m-d') . ' + 2 weeks ')),
                            'contract_end' => date('Y-m-d', strtotime(date('Y-m-d') . ' + 1 year + 2 weeks')),
                            'charges' => $amount_charged,
                            'bank_id' => $this->bank->id,
                        ]);
                    }
                }else{
                    $this->addError('notselected', 'Please Select Banks.');
                    return false;
                }
            }elseif($this->subscription == 'state'){
                $bank = CustomerBank::find($this->bank->id);
                $bank->display_reports = $this->subscription;
                $bank->save();
                foreach ($this->bank_city_filter as $key => $city) {
                    BankSelectedCity::create([
                        'bank_id' => $this->bank->id,
                        'city_id' => $city,
                    ]);
                }
                $charges = Packages::where('package_type', $this->subscription)->first();
                $contract = Contract::create([
                    'contract_start' => date('Y-m-d', strtotime(date('Y-m-d') )),
                    'contract_end' => date('Y-m-d', strtotime(date('Y-m-d') . ' + 1 year ')),
                    'charges' => $charges->price*count($this->bank_city_filter),
                    'bank_id' => $this->bank->id,
                ]);
            }
            return redirect()->route('invoice',['id'=>$this->bank->id, 'type'=>'complete']);
        }else{
            $this->addError('subscription','Please select a subscription to proceed.');
        }
    }

    public function deleteState($item){
        $state = State::where('name',$this->bank_state_filter_name[$item])->first();
        unset($this->bank_state_filter[array_search($state->id,$this->bank_state_filter)]);
        unset($this->bank_state_filter_name[$item]);
        $this->page = 1;
        $this->all_banks = null;
        $this->bank_city_filter = [];
        $this->bank_city_filter_name = [];
        $this->bank_cbsa_filter = [];
        $this->bank_cbsa_filter_name = [];
        // $this->custom_bank_select = Bank::whereIn('state_id',$this->custom_states)->get();
    }

    public function deleteCity($item){
        $bank = Bank::where('cbsa_name',$this->bank_city_filter_name[$item])->first();
        unset($this->bank_city_filter[array_search($bank->cbsa_code,$this->bank_city_filter)]);
        unset($this->bank_city_filter_name[$item]);
        $this->page = 1;
        $this->all_banks = null;
        $this->bank_cbsa_filter = [];
        $this->bank_cbsa_filter_name = [];
    }

    public function deleteCbsa($item){
        $this->all_banks = null;
        $this->page = 1;
        unset($this->bank_cbsa_filter[$item]);
        unset($this->bank_cbsa_filter_name[$item]);
    }

    public function calulate_current_amount(){
        if($this->subscription == ''){
            return 0;
        }elseif($this->subscription == 'custom'){
            $charges = Packages::where('package_type', $this->subscription)->first();
            if(count($this->custom_banks) <= $charges->number_of_units){
                return $charges->price;
            }else{
                $amount_charged = $charges->price + ($charges->additional_price*(count($this->custom_banks)-$charges->number_of_units));
                return $amount_charged;
            }
        }elseif($this->subscription == 'state'){
            $charges = Packages::where('package_type', $this->subscription)->first();
            return $charges->price*count($this->bank_city_filter);
        }
    }

    public function loadMore(){
        $this->page++;
        $this->update = true;
    }

    public function clear(){
        $this->bank_state_filter = [];
        $this->bank_state_filter_name = [];

        $this->bank_city_filter = [];
        $this->bank_city_filter_name = [];

        $this->bank_cbsa_filter = [];
        $this->bank_cbsa_filter_name = [];

        $this->selected_state_now = '';
        $this->selected_city_now = '';
        $this->selected_cbsa_now = '';

        $this->selectedbanks = [];

        $this->selected_banks_name = [];
        $this->custom_banks = [];
        $this->selectedItems = [];

    }

    public function zipCodeChanged(){
        $this->bank_state_filter = [];
        $this->bank_state_filter_name = [];

        $this->bank_city_filter = [];
        $this->bank_city_filter_name = [];

        $this->bank_cbsa_filter = [];
        $this->bank_cbsa_filter_name = [];

        $this->selected_state_now = '';
        $this->selected_city_now = '';
        $this->selected_cbsa_now = '';
        $this->page = 1;
        $this->all_banks = null;
    }
}
