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
use PDF;

class SpecialRateReports extends Component
{
    public $bank_state_filter = '';
    public $bank_city_filter = '';

    public function render()
    {
        $customer_bank = CustomerBank::find(Auth::user()->bank_id);
        if($customer_bank->display_reports == "state"){
            $city_id = BankSelectedCity::where('bank_id',Auth::user()->bank_id)->pluck('city_id');
            $bank_ids = Bank::whereIn('cbsa_code',$city_id)->pluck('id');
        }elseif($customer_bank->display_reports == "custom"){
            $bank_ids = CustomPackageBanks::where('bank_id',Auth::user()->bank_id)->pluck('customer_selected_bank_id');
        }

        $specialization_rates = SpecializationRates::join('banks', 'banks.id', '=', 'specialization_rates.bank_id')
            ->whereIn('banks.id', $bank_ids)
            ->select('specialization_rates.*')
            // ->whereRaw('specialization_rates.id = (SELECT MAX(id) FROM specialization_rates AS sr WHERE sr.bank_id = specialization_rates.bank_id)')
            ->whereRaw('specialization_rates.created_at = (SELECT MAX(created_at) FROM specialization_rates AS sr WHERE sr.bank_id = specialization_rates.bank_id)')
            ->orderBy('specialization_rates.rate','desc');

        if(!empty($this->bank_state_filter) && $this->bank_state_filter != 'all'){
            $specialization_rates->where('banks.state_id',$this->bank_state_filter);
        }
        if(!empty($this->bank_city_filter)){
            $specialization_rates->where('banks.city_id',$this->bank_city_filter);
        }
        $specialization_rates = $specialization_rates->get();

        $bank_states = $this->getStates($bank_ids);
        $bank_cities = $this->getmsacodes();
        return view('livewire.special-rate-reports', ['specialization_rates'=>$specialization_rates,'bank_states'=>$bank_states,'bank_cities'=>$bank_cities]);
    }

    public function getStates($bank_ids){
        $state = DB::table('specialization_rates')
            ->join('banks','banks.id','specialization_rates.bank_id')
            ->join('states','states.id','banks.state_id')
            ->whereIn('banks.id', $bank_ids)
            ->select('states.id','states.name')
            ->groupBy('state_id')
            ->get();
        return $state;
    }

    public function getmsacodes()
    {
        if($this->bank_state_filter!='' && $this->bank_state_filter!='all')
        {
            $msa_codes = Bank::with('cities')->where('state_id',$this->bank_state_filter)->groupBy('city_id')->get();
            return $msa_codes;
        }
        else
        {
            $customer_type = CustomerBank::where('id',auth()->user()->bank_id)->first();
            if($customer_type->display_reports == 'state'){
                $banks_city = DB::table('bank_selected_city')->where('bank_id',auth()->user()->bank_id)->pluck('city_id')->toArray();
                $msa_codes = Bank::with('cities')->whereIn('cbsa_code',$banks_city)->groupBy('cbsa_code')->get();
                return $msa_codes;
            }elseif($customer_type->display_reports == 'custom'){
                $msa_codes = Bank::with('cities')->groupBy('city_id')->get();
                return $msa_codes;
            }
        }

    }

    public function selectstate($id)
    {
        $this->bank_city_filter = "";
    }

    public function print_report()
    {
        $customer_bank = CustomerBank::find(Auth::user()->bank_id);
        if($customer_bank->display_reports == "state"){
            $city_id = BankSelectedCity::where('bank_id',Auth::user()->bank_id)->pluck('city_id');
            $bank_ids = Bank::whereIn('cbsa_code',$city_id)->pluck('id');
        }elseif($customer_bank->display_reports == "custom"){
            $bank_ids = CustomPackageBanks::where('bank_id',Auth::user()->bank_id)->pluck('customer_selected_bank_id');
        }

        $specialization_rates = SpecializationRates::join('banks', 'banks.id', '=', 'specialization_rates.bank_id')
            ->whereIn('banks.id', $bank_ids)
            ->select('specialization_rates.*')
            // ->whereRaw('specialization_rates.id = (SELECT MAX(id) FROM specialization_rates AS sr WHERE sr.bank_id = specialization_rates.bank_id)')
            ->whereRaw('specialization_rates.created_at = (SELECT MAX(created_at) FROM specialization_rates AS sr WHERE sr.bank_id = specialization_rates.bank_id)')
            ->orderBy('specialization_rates.rate','desc');

        if(!empty($this->bank_state_filter) && $this->bank_state_filter != 'all'){
            $specialization_rates->where('banks.state_id',$this->bank_state_filter);
        }
        if(!empty($this->bank_city_filter)){
            $specialization_rates->where('banks.city_id',$this->bank_city_filter);
        }
        $specialization_rates = $specialization_rates->get();
        $msa_codes = $this->getmsacodes();
        $pdf = PDF::loadView('reports.special_report_pdf', compact('specialization_rates','msa_codes'))->set_option("isPhpEnabled", true)->output();
        return response()->streamDownload(
            fn () => print($pdf),
            "Special_Report.pdf"
        );
        $this->render();
    }
}
