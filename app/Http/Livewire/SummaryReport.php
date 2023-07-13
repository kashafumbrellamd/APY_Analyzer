<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\RateType;
use App\Models\BankPrices;
use App\Models\Bank;


class SummaryReport extends Component
{
    public $columns = [];
    public $last_updated = '';
    public $selected_bank = '';

    public function render()
    {
        $rt = RateType::orderby('id','ASC')->get();
        foreach ($rt as $key => $value) {
            $data = BankPrices::summary_report($value->id);
            // $data = BankPrices::select('bank_prices.id', 'bank_prices.rate_type_id','bank_prices.previous_rate','bank_prices.current_rate','bank_prices.change', 'bank_prices.rate', 'bank_prices.created_at','bank_prices.is_checked','rate_types.name as rate_type_name','banks.name as bk_name','banks.id as bk_id')
            // ->whereIn('bank_prices.created_at', function ($query) use ($value) {
            //     $query->selectRaw('MAX(created_at)')
            //         ->from('bank_prices')
            //         ->where('rate_type_id', $value->id)
            //         ->where('is_checked','1')
            //         ->groupBy('bank_id')
            //         ->groupBy('rate_type_id');
            // })
            // ->where('bank_prices.rate_type_id', $value->id)
            // ->join('rate_types', 'bank_prices.rate_type_id', '=', 'rate_types.id')
            // ->join('banks', 'bank_prices.bank_id', '=', 'banks.id')
            // ->orderBy('bank_prices.current_rate','desc')
            // ->get();
            $value->data = $data;
        }
        $this->last_updated = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', BankPrices::max('updated_at'))->format('m-d-Y');
        if($this->columns == [])
        {
            $this->fill($rt);
        }
        $banks = Bank::get();
        return view('livewire.summary-report',['rate_type'=>$rt,'banks'=>$banks]);
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
