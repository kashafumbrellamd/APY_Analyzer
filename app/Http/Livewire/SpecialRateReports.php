<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\SpecializationRates;
use DB;
use Auth;
use App\Models\Bank;
use App\Models\CustomerBank;
use App\Models\CustomPackageBanks;
use App\Models\BankSelectedCity;
use App\Models\State;
use App\Models\Cities;

class SpecialRateReports extends Component
{
    public $bank_state_filter = '';
    public $bank_city_filter = '';

    public function render()
    {
        $customer_bank = CustomerBank::find(Auth::user()->bank_id);
        if($customer_bank->display_reports == "state"){
            $city_id = BankSelectedCity::where('bank_id',Auth::user()->bank_id)->pluck('city_id');
            $bank_ids = Bank::whereIn('city_id',$city_id)->pluck('id');
        }elseif($customer_bank->display_reports == "custom"){
            $bank_ids = CustomPackageBanks::where('bank_id',Auth::user()->bank_id)->pluck('customer_selected_bank_id');
        }

        $specialization_rates = SpecializationRates::join('banks', 'banks.id', '=', 'specialization_rates.bank_id')
            ->whereIn('banks.id', $bank_ids)
            ->select('specialization_rates.*')
            ->whereRaw('specialization_rates.id = (SELECT MAX(id) FROM specialization_rates AS sr WHERE sr.bank_id = specialization_rates.bank_id)');

        if(!empty($this->bank_state_filter)){
            $specialization_rates->where('banks.state_id',$this->bank_state_filter);
        }
        if(!empty($this->bank_city_filter)){
            $specialization_rates->where('banks.city_id',$this->bank_city_filter);
        }
        $specialization_rates = $specialization_rates->get();
        $bank_states = $this->getStates();
        $bank_cities = $this->getCities();
        return view('livewire.special-rate-reports', ['specialization_rates'=>$specialization_rates,'bank_states'=>$bank_states,'bank_cities'=>$bank_cities]);
    }

    public function getStates(){
        $state = DB::table('specialization_rates')
            ->join('banks','banks.id','specialization_rates.bank_id')
            ->join('states','states.id','banks.state_id')
            ->select('states.id','states.name')
            ->groupBy('state_id')
            ->get();
        return $state;
    }

    public function getCities()
    {
        if($this->bank_state_filter!='' && $this->bank_state_filter!='all')
        {
            $msa_codes = DB::table('specialization_rates')
            ->join('banks','banks.id','specialization_rates.bank_id')
            ->join('cities','cities.id','banks.city_id')
            ->where('banks.state_id',$this->bank_state_filter)
            ->select('cities.id','cities.name')
            ->groupBy('city_id')
            ->get();
            return $msa_codes;
        }
        else
        {
            $msa_codes = DB::table('specialization_rates')
                ->join('banks','banks.id','specialization_rates.bank_id')
                ->join('cities','cities.id','banks.city_id')
                ->select('cities.id','cities.name')
                ->groupBy('city_id')
                ->get();
            return $msa_codes;
        }
    }

    public function selectstate($id)
    {
        $this->bank_city_filter = "";
    }
}
