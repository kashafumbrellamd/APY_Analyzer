<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Bank;
use App\Models\BankPrices;
use App\Models\CustomerBank;
use App\Models\User;
use App\Models\State;
use App\Models\Role;
use App\Models\RateType;
use DB;

class DetailedReport extends Component
{

    public $columns = [];
    public $state_id = '';
    public $msa_code = '';
    public $last_updated = '';
    public function render()
    {
        $rt = RateType::orderby('name','ASC')->get();
        $data = BankPrices::all();
        $customer_type = CustomerBank::where('id',auth()->user()->bank_id)->first();
        $states = $this->getstates();
        $msa_codes = $this->getmsacodes();
        $this->last_updated = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', BankPrices::max('updated_at'))->format('m-d-Y');
        if($this->state_id!='' && $this->state_id!='all'){
            $reports = BankPrices::BankReportsWithState($this->state_id);
            $results = BankPrices::get_min_max_func_with_state($this->state_id);
        }elseif ($this->msa_code != '' && $this->msa_code!='all') {
            $reports = BankPrices::BankReportsWithMsa($this->msa_code);
            $results = BankPrices::get_min_max_func_with_msa($this->state_id);
        }else {
            $reports = BankPrices::BankReports();
            $results = BankPrices::get_min_max_func();
        }
        if($this->columns == [])
        {
            $this->fill($rt);
        }
        return view('livewire.detailed-report',['rate_type'=>$rt,'data'=>$data,'reports'=>$reports,'customer_type'=>$customer_type,'states'=>$states,'msa_codes'=>$msa_codes,'results'=>$results]);
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
        $states = Bank::join('states', 'banks.state_id', '=', 'states.id')
        ->select('states.*')
        ->groupBy('states.id')
        ->get();
        return $states;
    }

    public function getmsacodes()
    {
        $customer_type = CustomerBank::where('id',auth()->user()->bank_id)->first();
        $msa_codes = Bank::where('state_id',$customer_type->state)->groupBy('msa_code')->get();
        return $msa_codes;
    }

    public function clear()
    {
        $this->state_id = '';
        $this->msa_code = '';
    }
}
