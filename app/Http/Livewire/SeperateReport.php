<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Bank;
use App\Models\BankPrices;
use App\Models\CustomerBank;
use App\Models\CustomPackageBanks;
use App\Models\User;
use App\Models\State;
use App\Models\Role;
use App\Models\RateType;
use App\Models\BankType;
use DB;
use PDF;

class SeperateReport extends Component
{

    public $columns = [];
    public $reports;
    public $results;
    public $state_id = '';
    public $msa_code = '';
    public $last_updated = '';
    public $selected_bank = '';
    public $selected_bank_type = '';
    public function render()
    {
        $rt = RateType::orderby('id','ASC')->get();
        $customer_type = CustomerBank::where('id',auth()->user()->bank_id)->first();
        $states = $this->getstates();
        $msa_codes = $this->getmsacodes();
        $this->last_updated = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', BankPrices::max('updated_at'))->format('m-d-Y');
        if($this->state_id!='' && $this->state_id!='all'){
            $response = BankPrices::SeperateReports('state',$this->state_id,$this->msa_code,$this->selected_bank_type);
            $this->reports = $response['rate_types'];
            $this->results = BankPrices::get_min_max_func('state',$this->state_id,$this->msa_code,$this->selected_bank_type);
        }elseif ($this->msa_code != '' && $this->msa_code!='all') {
            $response = BankPrices::SeperateReports('msa','all',$this->msa_code,$this->selected_bank_type);
            $this->reports = $response['rate_types'];
            $this->results = BankPrices::get_min_max_func('msa','all',$this->msa_code,$this->selected_bank_type);
        }else {
            $response = BankPrices::SeperateReports('all','all','0',$this->selected_bank_type);
            $this->reports = $response['rate_types'];
            $this->results = BankPrices::get_min_max_func('all','all','0',$this->selected_bank_type);
        }
        if($this->columns == [])
        {
            $this->fill($rt);
        }
        $banks = $response['show_banks'];
        $bankTypes = BankType::where('status','1')->get();
        return view('livewire.seperate-report',['customer_type'=>$customer_type,'states'=>$states,'msa_codes'=>$msa_codes,'bankTypes'=>$bankTypes,'banks'=>$banks]);
    }

    public function fill($data)
    {
        foreach ($data as $key => $dt) {
            $this->columns[$dt->id] = 1;
        }
    }

    public function check_column($id)
    {
        if($this->columns[$id] == 1){
            $this->columns[$id] = 0;
        }else{
            $this->columns[$id] = 1;
        }
    }

    public function getstates()
    {
        $selected_banks = CustomPackageBanks::where('bank_id',auth()->user()->bank_id)
        ->join('banks', 'custom_package_banks.customer_selected_bank_id', '=', 'banks.id')
        ->pluck('banks.state_id')->toArray();
        $states = State::whereIn('id',$selected_banks)->get();
        // $states = Bank::join('states', 'banks.state_id', '=', 'states.id')
        // ->select('states.*')
        // ->groupBy('states.id')
        // ->get();
        return $states;
    }

    public function getmsacodes()
    {
        if($this->state_id!='' && $this->state_id!='all')
        {
            $msa_codes = Bank::with('cities')->where('state_id',$this->state_id)->groupBy('city_id')->get();
            return $msa_codes;
        }
        else
        {
            $msa_codes = Bank::with('cities')->groupBy('city_id')->get();
            return $msa_codes;
        }
        
    }

    public function selectAll(){
        foreach ($this->columns as $key => $dt) {
                $this->columns[$key] = 1;
        }
        $this->render();
    }

    public function deselectAll(){
        foreach ($this->columns as $key => $dt) {
                $this->columns[$key] = 0;
        }
        $this->render();
    }

    public function print_report()
    {
        $rt = RateType::orderby('id','ASC')->get();
        if($this->state_id!='' && $this->state_id!='all'){
            $reports = BankPrices::SeperateReports('state',$this->state_id,$this->selected_bank_type);
            $results = BankPrices::get_min_max_func('state',$this->state_id,$this->selected_bank_type);
        }elseif ($this->msa_code != '' && $this->msa_code!='all') {
            $reports = BankPrices::SeperateReports('msa',$this->msa_code,$this->selected_bank_type);
            $results = BankPrices::get_min_max_func('msa',$this->msa_code,$this->selected_bank_type);
        }else {
            $reports = BankPrices::SeperateReports('all','0',$this->selected_bank_type);
            $results = BankPrices::get_min_max_func('all','0',$this->selected_bank_type);
        }
        if($this->columns == [])
        {
            $this->fill($rt);
        }
        $columns = $this->columns;
        $pdf = PDF::loadView('reports.seperate_report_pdf', compact('reports','results','columns'))->output();
        return response()->streamDownload(
            fn () => print($pdf),
            "Seperate_Report.pdf"
        );
        $this->render();
    }

    public function clear()
    {
        $this->state_id = '';
        $this->msa_code = '';
    }

    public function selectstate($id)
    {
        $this->state_id = $id;
        $this->msa_code = '';
        $this->render();
    }
}
