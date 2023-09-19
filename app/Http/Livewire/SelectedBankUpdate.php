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
use DB;
use Auth;
use Livewire\Component;

class SelectedBankUpdate extends Component
{
    public $subscription = 'custom';

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

    public function mount(){
        $this->addSelected();
    }

    public function render()
    {
        $states = State::where('country_id', '233')->get();
        $data = CustomPackageBanks::where('bank_id',Auth::user()->bank_id)
            ->join('banks','banks.id','custom_package_banks.customer_selected_bank_id')
            ->select('banks.*')
            ->get();
        $this->all_banks = $this->fetch_banks();
        $bank_cities = Cities::get();
        $packages = Packages::get();
        $this->selected_package = Packages::where('package_type',$this->subscription)->first();
        $bank_types = BankType::where('status', 1)->get();
        $available_states = $this->getStates();
        $available_cities = $this->getCities();
        $available_cbsa = $this->getCBSA();
        return view('livewire.selected-bank-update', compact('data','packages', 'bank_types', 'bank_cities','available_states','available_cities','available_cbsa'));
    }

    public function addSelected(){
       $already =  CustomPackageBanks::where('bank_id',Auth::user()->bank_id)->pluck('customer_selected_bank_id')->toArray();
       $this->custom_banks = $already;
    }

    public function selectbanktype($id)
    {
        $this->bank_state_filter = [];
        $this->bank_state_filter_name = [];
        $this->bank_city_filter = [];
        $this->bank_city_filter_name = [];
        $this->bank_cbsa_filter = [];
        $this->bank_cbsa_filter_name = [];
    }

    public function getStates()
    {
        if ($this->bank_type != "") {
            $state = DB::table('banks')
                ->join('states', 'states.id', 'banks.state_id')
                ->select('states.id', 'states.name')
                ->where('banks.bank_type_id', $this->bank_type)
                ->groupBy('state_id')
                ->get();
        } else {
            $state = DB::table('banks')
                ->join('states', 'states.id', 'banks.state_id')
                ->select('states.id', 'states.name')
                ->groupBy('state_id')
                ->get();
        }
        return $state;
    }

    public function getCities()
    {
        if ($this->bank_state_filter != '' && $this->bank_state_filter != 'all' && $this->bank_type != "") {
            $msa_codes = Bank::with('cities')->whereIn('state_id', $this->bank_state_filter)->where('bank_type_id', $this->bank_type)->groupBy('city_id')->get();
        } elseif ($this->bank_state_filter == '' && $this->bank_state_filter == 'all' && $this->bank_type != "") {
            $msa_codes = Bank::with('cities')->where('bank_type_id', $this->bank_type)->groupBy('city_id')->get();
        } elseif ($this->bank_state_filter != '' && $this->bank_state_filter != 'all' && $this->bank_type == "") {
            $msa_codes = Bank::with('cities')->whereIn('state_id', $this->bank_state_filter)->groupBy('city_id')->get();
        } elseif ($this->bank_state_filter == '' && $this->bank_state_filter == 'all' && $this->bank_type == "") {
            $msa_codes = Bank::with('cities')->groupBy('city_id')->get();
        }
        return $msa_codes;

    }

    public function getCBSA()
    {
        if ($this->bank_state_filter != '' && $this->bank_state_filter != 'all' && $this->bank_type != "") {
            $cbsa_codes = Bank::whereIn('state_id', $this->bank_state_filter)
                ->where('bank_type_id', $this->bank_type)
                ->groupBy('city_id')
                ->get();
        } elseif ($this->bank_state_filter == '' && $this->bank_state_filter == 'all' && $this->bank_type != "") {
            $cbsa_codes = Bank::with('cities')
                ->where('bank_type_id', $this->bank_type)
                ->groupBy('city_id')
                ->get();
        } elseif ($this->bank_state_filter != '' && $this->bank_state_filter != 'all' && $this->bank_type == "") {
            $cbsa_codes = Bank::with('cities')
                ->whereIn('state_id', $this->bank_state_filter)
                ->groupBy('city_id')
                ->get();
        } elseif ($this->bank_state_filter == '' && $this->bank_state_filter == 'all' && $this->bank_type == "") {
            $cbsa_codes = Bank::select('cbsa_code','cbsa_name')->get();
        }
        return $cbsa_codes;
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
        $this->selected_state_now = '';
        $this->bank_city_filter = [];
        $this->bank_city_filter_name = [];
    }

    public function selectcity($id)
    {
        if ($id == "all") {
            $this->bank_city_filter = [];
            $this->bank_city_filter_name = [];
        } else {
            if (!in_array($id, $this->bank_city_filter)) {
                array_push($this->bank_city_filter, $id);
                array_push($this->bank_city_filter_name, Cities::find($id)->name);
            }
        }
        $this->selected_city_now = '';
    }

    public function selectcbsa($id)
    {
        if ($id == "all") {
            $this->bank_city_filter = [];
            $this->bank_city_filter_name = [];
        } else {
            if (!in_array($id, $this->bank_cbsa_filter)) {
                array_push($this->bank_cbsa_filter, $id);
                array_push($this->bank_cbsa_filter_name, $id);
            }
        }
        $this->selected_city_now = '';
    }

    public function deleteState($item){
        $state = State::where('name',$this->bank_state_filter_name[$item])->first();
        unset($this->bank_state_filter[array_search($state->id,$this->bank_state_filter)]);
        unset($this->bank_state_filter_name[$item]);
        $this->bank_city_filter = [];
        $this->bank_city_filter_name = [];
        // $this->custom_bank_select = Bank::whereIn('state_id',$this->custom_states)->get();
    }

    public function deleteCity($item){
        $bank = Cities::where('name',$this->bank_city_filter_name[$item])->first();
        unset($this->bank_city_filter[array_search($bank->id,$this->bank_city_filter)]);
        unset($this->bank_city_filter_name[$item]);
    }

    public function deleteCbsa($item){
        unset($this->bank_cbsa_filter[$item]);
        unset($this->bank_cbsa_filter_name[$item]);
    }

    public function fetch_banks()
    {
        if ($this->bank_state_filter != [] && $this->bank_city_filter != [] && $this->bank_type != "") {
            $All_banks = Bank::join('states', 'banks.state_id', 'states.id')
                ->join('cities', 'banks.city_id', 'cities.id')
                ->join('bank_types', 'banks.bank_type_id', 'bank_types.id')
                ->where('bank_types.status', 1)
                ->whereIn('banks.state_id', $this->bank_state_filter)
                ->whereIn('banks.city_id', $this->bank_city_filter)
                ->where('banks.bank_type_id', $this->bank_type)
                ->select('banks.*', 'states.name as state_name', 'cities.name as city_name')
                ->get();
        } elseif ($this->bank_state_filter != [] && $this->bank_city_filter == [] && $this->bank_type != "") {
            $All_banks = Bank::join('states', 'banks.state_id', 'states.id')
                ->join('cities', 'banks.city_id', 'cities.id')
                ->join('bank_types', 'banks.bank_type_id', 'bank_types.id')
                ->where('bank_types.status', 1)
                ->whereIn('banks.state_id', $this->bank_state_filter)
                ->where('banks.bank_type_id', $this->bank_type)
                ->select('banks.*', 'states.name as state_name', 'cities.name as city_name')
                ->get();
        } elseif ($this->bank_state_filter == [] && $this->bank_city_filter == [] && $this->bank_type != "") {
            $All_banks = Bank::join('states', 'banks.state_id', 'states.id')
                ->join('cities', 'banks.city_id', 'cities.id')
                ->join('bank_types', 'banks.bank_type_id', 'bank_types.id')
                ->where('bank_types.status', 1)
                ->where('banks.bank_type_id', $this->bank_type)
                ->select('banks.*', 'states.name as state_name', 'cities.name as city_name')
                ->get();
        } elseif ($this->bank_state_filter != [] && $this->bank_city_filter != [] && $this->bank_type == "") {
            $All_banks = Bank::join('states', 'banks.state_id', 'states.id')
                ->join('cities', 'banks.city_id', 'cities.id')
                ->join('bank_types', 'banks.bank_type_id', 'bank_types.id')
                ->where('bank_types.status', 1)
                ->whereIn('banks.state_id', $this->bank_state_filter)
                ->whereIn('banks.city_id', $this->bank_city_filter)
                ->select('banks.*', 'states.name as state_name', 'cities.name as city_name')
                ->get();
        } elseif ($this->bank_state_filter != [] && $this->bank_city_filter == [] && $this->bank_type == "") {
            $All_banks = Bank::join('states', 'banks.state_id', 'states.id')
                ->join('cities', 'banks.city_id', 'cities.id')
                ->join('bank_types', 'banks.bank_type_id', 'bank_types.id')
                ->where('bank_types.status', 1)
                ->whereIn('banks.state_id', $this->bank_state_filter)
                ->select('banks.*', 'states.name as state_name', 'cities.name as city_name')
                ->get();
        } elseif ($this->bank_state_filter == [] && $this->bank_city_filter == [] && $this->bank_type == "") {
            $All_banks = Bank::join('states', 'banks.state_id', 'states.id')
                ->join('cities', 'banks.city_id', 'cities.id')
                ->join('bank_types', 'banks.bank_type_id', 'bank_types.id')
                ->where('bank_types.status', 1)
                ->select('banks.*', 'states.name as state_name', 'cities.name as city_name')
                ->get();
        }
        return $All_banks;
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
        } else {
            array_push($this->custom_banks, $id);
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
}
