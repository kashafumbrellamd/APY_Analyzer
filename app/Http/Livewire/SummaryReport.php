<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\RateType;
use App\Models\BankPrices;
use App\Models\Bank;
use App\Models\BankType;


class SummaryReport extends Component
{
    public $columns = [];
    public $last_updated = '';
    public $selected_bank = '';
    public $selected_bank_type = '';

    public function render()
    {
        $rt = RateType::orderby('id','ASC')->get();
        foreach ($rt as $key => $value) {
            $data = BankPrices::summary_report($value->id,$this->selected_bank_type);
            $value->data = $data;
        }
        $this->last_updated = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', BankPrices::max('updated_at'))->format('m-d-Y');
        if($this->columns == [])
        {
            $this->fill($rt);
        }
        $banks = Bank::get();
        $bankTypes = BankType::where('status','1')->get();
        return view('livewire.summary-report',['rate_type'=>$rt,'banks'=>$banks,'bankTypes'=>$bankTypes]);
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
}
