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
use App\Models\Payment;
use DB;
use Auth;
use Livewire\Component;
use App\Models\StandardReportList;

class SelectedBankUpdate extends Component
{
    public $subscription;
    public $already;

    public $all_banks = null;
    public $bank_type = '';

    public $bank_state_filter = [];
    public $bank_state_filter_name = [];

    public $bank_city_filter = [];
    public $bank_city_filter_name = [];

    public $bank_cbsa_filter = [];
    public $bank_cbsa_filter_name = [];

    public $selected_state_now = '';
    public $selected_city_now = '';
    public $selected_cbsa_now = '';

    public $custom_banks = [];
    public $selectedbanks = [];

    public $selected_banks_name = [];

    public $current_amount = '';
    public $page = 1;
    public $update = true;

    public $selectedItems = [];
    public $standard_report_list;

    public function mount(){
        $this->addSelected();
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
        $this->subscription = CustomerBank::where('id',Auth::user()->bank_id)->pluck('display_reports')->first();
        $this->selected_package = Packages::where('package_type',$this->subscription)->first();
        $bank_types = BankType::where('status', 1)->get();
        $available_states = $this->getStates();
        $available_cities = $this->getCities();
        $available_cbsa = $this->getCBSA();
        $this->current_amount = $this->calulate_current_amount();
        $this->standard_report_list = StandardReportList::where('status','1')->get();
        $data = CustomPackageBanks::where('bank_id',Auth::user()->bank_id)
            ->join('banks','banks.id','custom_package_banks.customer_selected_bank_id')
            ->select('custom_package_banks.id as cpb_id','banks.*')
            ->get();
        return view('livewire.selected-bank-update', compact('data','packages', 'bank_types', 'available_states','available_cities','available_cbsa'));
    }

    public function addSelected(){
       $this->already =  CustomPackageBanks::where('bank_id',Auth::user()->bank_id)->pluck('customer_selected_bank_id')->toArray();
       $this->custom_banks = $this->already;
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
        $this->all_banks = null;
        $this->selected_state_now = '';
        $this->bank_city_filter = [];
        $this->bank_city_filter_name = [];
        $this->bank_cbsa_filter = [];
        $this->bank_cbsa_filter_name = [];
        $this->page = 1;
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
        $this->all_banks = null;
        $this->selected_city_now = '';
        $this->bank_cbsa_filter = [];
        $this->bank_cbsa_filter_name = [];
        $this->page = 1;
    }

    public function selectcbsa($id)
    {
        if ($id == "all") {
            $this->bank_cbsa_filter = [];
            $this->bank_cbsa_filter_name = [];
        } else {
            if (!in_array($id, $this->bank_cbsa_filter)) {
                array_push($this->bank_cbsa_filter, $id);
                $cbsssa_name = Bank::where('cbsa_code',$id)->select('cbsa_name')->first();
                array_push($this->bank_cbsa_filter_name, $cbsssa_name->cbsa_name);
            }
        }
        $this->all_banks = null;
        $this->selected_city_now = '';
        $this->page = 1;
    }

    public function deleteState($item){
        $state = State::where('name',$this->bank_state_filter_name[$item])->first();
        unset($this->bank_state_filter[array_search($state->id,$this->bank_state_filter)]);
        unset($this->bank_state_filter_name[$item]);
        $this->all_banks = null;
        $this->bank_city_filter = [];
        $this->bank_city_filter_name = [];
        $this->bank_cbsa_filter = [];
        $this->bank_cbsa_filter_name = [];
        // $this->custom_bank_select = Bank::whereIn('state_id',$this->custom_states)->get();
        $this->page = 1;
    }

    public function deleteCity($item){
        // $bank = Cities::where('name',$this->bank_city_filter_name[$item])->first();
        // unset($this->bank_city_filter[array_search($bank->id,$this->bank_city_filter)]);
        // unset($this->bank_city_filter_name[$item]);
        $bank = Bank::where('cbsa_name',$this->bank_city_filter_name[$item])->first();
        unset($this->bank_city_filter[array_search($bank->cbsa_code,$this->bank_city_filter)]);
        unset($this->bank_city_filter_name[$item]);
        $this->all_banks = null;
        $this->bank_cbsa_filter = [];
        $this->bank_cbsa_filter_name = [];
        $this->page = 1;
    }

    public function deleteCbsa($item){
        $this->all_banks = null;
        unset($this->bank_cbsa_filter[$item]);
        unset($this->bank_cbsa_filter_name[$item]);
        $this->page = 1;
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
        return $query->skip(($page-1)*50)->take(50)->get();
    }

    public function select_all_banks()
    {
        foreach ($this->all_banks as $bank) {
            if (!in_array($bank->id, $this->custom_banks)) {
                array_push($this->custom_banks, $bank->id);
            }
            array_push($this->selectedbanks, $bank->id);
        }
        $All_banks = Bank::whereIn('banks.id', $this->selectedbanks)
            ->join('states', 'banks.state_id', 'states.id')
            ->join('cities', 'banks.city_id', 'cities.id')
            ->select('banks.*', 'states.name as state_name', 'cities.name as city_name')
            ->get();
        $this->all_banks = $All_banks;
        $this->selectedbanks = [];
    }

    public function deselect_all_banks()
    {
        foreach ($this->all_banks as $bank) {
            if (in_array($bank->id, $this->custom_banks)) {
                unset($this->custom_banks[array_search($bank->id, $this->custom_banks)]);
            }
            array_push($this->selectedbanks, $bank->id);
        }
        $All_banks = Bank::whereIn('banks.id', $this->selectedbanks)
            ->join('states', 'banks.state_id', 'states.id')
            ->join('cities', 'banks.city_id', 'cities.id')
            ->select('banks.*', 'states.name as state_name', 'cities.name as city_name')
            ->get();
        $this->all_banks = $All_banks;
        $this->selectedbanks = [];
    }

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
        $All_banks = Bank::whereIn('banks.id', $this->selectedbanks)
            ->join('states', 'banks.state_id', 'states.id')
            ->join('cities', 'banks.city_id', 'cities.id')
            ->select('banks.*', 'states.name as state_name', 'cities.name as city_name')
            ->get();
        $this->all_banks = $All_banks;
        $this->selectedbanks = [];
    }

    public function deleteRequest($id){
        $details = CustomPackageBanks::find($id);
        $check = DB::table('temp_custom_bank')->where('bank_id',$details->bank_id)->where('customer_selected_bank_id',$details->customer_selected_bank_id)->first();
        if($check == null){
            DB::table('temp_custom_bank')->insert([
                "bank_id" => $details->bank_id,
                "customer_selected_bank_id" => $details->customer_selected_bank_id,
                "type" => "remove",
                "created_at" => NOW(),
                "updated_at" => NOW(),
            ]);
        }
        $this->addError('request','The Delete Request Has been Successfully Submitted.');
    }

    public function save_banks(){
        // dd($this->selectedItems);
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
        $payment = Payment::where('bank_id',Auth::user()->bank_id)->where('status','0')->first();
        if($payment == null){
            if($this->subscription == 'custom'){
                $toBeAdded = array_diff($this->custom_banks,$this->already);
                foreach ($toBeAdded as $key => $custom_bank) {
                    $check = CustomPackageBanks::where('bank_id',Auth::user()->bank_id)
                    ->where('customer_selected_bank_id',$custom_bank)
                    ->first();
                    if($check == null){
                        DB::table('temp_custom_bank')->insert([
                            "bank_id" => Auth::user()->bank_id,
                            "customer_selected_bank_id" => $custom_bank,
                            "type" => "add",
                            "created_at" => NOW(),
                            "updated_at" => NOW(),
                        ]);
                    }
                }

                $charges = Packages::where('package_type', $this->subscription)->first();
                $contract = Contract::where('bank_id',Auth::user()->bank_id)->orderBy('id','desc')->first();
                if(count($this->custom_banks) <= $charges->number_of_units){
                     Contract::create([
                        'contract_start' => $contract->contract_start,
                        'contract_end' => $contract->contract_end,
                        'charges' => 0,
                        'bank_id' => $contract->bank_id,
                        'contract_type' => 'partial',
                    ]);
                    Payment::create([
                        'bank_id' => $contract->bank_id,
                        'cheque_number' => "null",
                        'cheque_image' => "null",
                        'amount' => 0,
                        'bank_name' => "null",
                        'status' => "0",
                        'payment_type' => "partial",
                    ]);
                    $this->addError('request','The request has been successfully submitted.');
                    $this->clear();

                }elseif(count($this->already) <= $charges->number_of_units){
                    $difference = strtotime($contract->contract_end)-strtotime(date('Y-m-d'));
                    $months_remain = (int)($difference/(60*60*24*30));

                    $price = $charges->additional_price;
                    $priceToBePaid = round(($price/12)*$months_remain,2)*(abs(count($this->already)+count($toBeAdded)-$charges->number_of_units));
                    Contract::create([
                        'contract_start' => $contract->contract_start,
                        'contract_end' => $contract->contract_end,
                        'charges' => $priceToBePaid,
                        'bank_id' => $contract->bank_id,
                        'contract_type' => 'partial',
                    ]);
                    // return redirect()->route('payment',['id'=>Auth::user()->bank_id,'type'=>'partial']);
                    Payment::create([
                        'bank_id' => $contract->bank_id,
                        'cheque_number' => "null",
                        'cheque_image' => "null",
                        'amount' => 0,
                        'bank_name' => "null",
                        'status' => "0",
                        'payment_type' => "partial",
                    ]);
                    $this->addError('request','The request has been successfully submitted.');
                    $this->clear();
                }else{
                    $difference = strtotime($contract->contract_end)-strtotime(date('Y-m-d'));
                    $months_remain = (int)($difference/(60*60*24*30));

                    $price = $charges->additional_price;
                    $priceToBePaid = round(($price/12)*$months_remain,2)*(abs(count($toBeAdded)));
                    Contract::create([
                        'contract_start' => $contract->contract_start,
                        'contract_end' => $contract->contract_end,
                        'charges' => $priceToBePaid,
                        'bank_id' => $contract->bank_id,
                        'contract_type' => 'partial',
                    ]);
                    // return redirect()->route('payment',['id'=>Auth::user()->bank_id,'type'=>'partial']);
                    Payment::create([
                        'bank_id' => $contract->bank_id,
                        'cheque_number' => "null",
                        'cheque_image' => "null",
                        'amount' => 0,
                        'bank_name' => "null",
                        'status' => "0",
                        'payment_type' => "partial",
                    ]);
                    $this->addError('request','The request has been successfully submitted.');
                    $this->clear();

                }
            }elseif($this->subscription == 'state'){
                $charges = Packages::where('package_type', $this->subscription)->first();
                $price = $charges->price;
                $contract = Contract::where('bank_id',Auth::user()->bank_id)->orderBy('id','desc')->first();
                $difference = strtotime($contract->contract_end)-strtotime(date('Y-m-d'));
                $months_remain = (int)($difference/(60*60*24*30));
                $priceToBePaid = round(($price/12)*$months_remain,2)*(abs(count($this->bank_city_filter)));

                Contract::create([
                    'contract_start' => $contract->contract_start,
                    'contract_end' => $contract->contract_end,
                    'charges' => $priceToBePaid,
                    'bank_id' => $contract->bank_id,
                    'contract_type' => 'partial',
                ]);
                foreach ($this->bank_city_filter as $key => $city) {
                    $check_city = BankSelectedCity::where('bank_id',Auth::user()->bank_id)->where('city_id',$city)->first();
                    if($check_city == null){
                        BankSelectedCity::create([
                            'bank_id' => Auth::user()->bank_id,
                            'city_id' => $city,
                        ]);
                    }else{
                        unset($this->bank_city_filter[$key]);
                    }
                }
                // return redirect()->route('payment',['id'=>Auth::user()->bank_id,'type'=>'partial']);
                Payment::create([
                    'bank_id' => Auth::user()->bank_id,
                    'cheque_number' => "null",
                    'cheque_image' => "null",
                    'amount' => 0,
                    'bank_name' => "null",
                    'status' => "0",
                    'payment_type' => "partial",
                ]);
                $this->addError('request','The request has been successfully submitted.');
                $this->clear();
            }
        }else{
            $this->addError('payment','Please Wait for the Previous Request to be completed before Changing');
        }

    }

    public function calulate_current_amount(){
        if($this->subscription == 'custom'){
            $charges = Packages::where('package_type', $this->subscription)->first();
            if(count($this->custom_banks) <= $charges->number_of_units){
                return 0;
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
        foreach($this->selectedItems as $id){
            if (($key = array_search($id, $this->custom_banks)) !== false) {
                unset($this->custom_banks[$key]);
            }
        }
        $this->selectedItems = [];
        $this->custom_banks = array_values($this->custom_banks);
        // dd($this->custom_banks,$this->selectedItems);
        // $this->custom_banks = [];
    }
}
