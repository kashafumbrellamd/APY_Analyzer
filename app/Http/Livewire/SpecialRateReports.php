<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\SpecializationRates;
use DB;
use App\Models\Bank;
use App\Models\State;
use App\Models\Cities;

class SpecialRateReports extends Component
{
    public $bank_state_filter = '';
    public $bank_city_filter = '';

    public function render()
    {
        if($this->bank_state_filter != '' && $this->bank_city_filter == ''){
            $specialization_rates = SpecializationRates::join('banks','banks.id','specialization_rates.bank_id')
                ->where('banks.state_id',$this->bank_state_filter)
                ->get();
        }elseif($this->bank_state_filter == '' && $this->bank_city_filter != ''){
            $specialization_rates = SpecializationRates::join('banks','banks.id','specialization_rates.bank_id')
                ->where('banks.city_id',$this->bank_city_filter)
                ->get();
        }elseif($this->bank_state_filter != '' && $this->bank_city_filter != ''){
            $specialization_rates = SpecializationRates::join('banks','banks.id','specialization_rates.bank_id')
                ->where('banks.state_id',$this->bank_state_filter)
                ->where('banks.city_id',$this->bank_city_filter)
                ->get();
        }else{
            $specialization_rates = SpecializationRates::with('bank')->get();
        }
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
