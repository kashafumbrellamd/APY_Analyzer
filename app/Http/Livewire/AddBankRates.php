<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\RateType;
use App\Models\Bank;
use App\Models\BankPrices;
use App\Models\State;
use Illuminate\Support\Str;

class AddBankRates extends Component
{
    public $update = false;
    public $bank_id = '';
    public $bank = '';
    public $state_name = '';
    public $rate = '';
    public $rate_type_id = '';
    
    public function render()
    {
        $data = Bank::BanksWithState();
        $rate_types = RateType::all();
        $bank_prices = BankPrices::BankPricesWithType($this->bank_id);
        return view('livewire.add-bank-rates',['data'=>$data,'bank_prices'=>$bank_prices,'update'=>$this->update,'rate_types'=>$rate_types]);
    }

    public function onbankselect($id)
    {
        $this->bank_id = $id;
        if($id!=0)
        {
            $this->bank = Bank::find($id);
            $state = State::find($this->bank->state_id);
            $this->state_name = $state->name;
        }
        else
        {
            $this->bank = '';
            $this->state_name = '';
        }
        $this->rate_type_id = '';
        $this->render();
    }

    public function submitForm()
    {
        if($this->bank_id!='' && $this->rate_type_id!='' && $this->rate!='' && $this->bank_id!=0)
        {
            $check = BankPrices::where('bank_id',$this->bank_id)->where('rate_type_id',$this->rate_type_id)
            ->orderby('id','DESC')->first();
            if(auth()->user()->hasRole('admin'))
            {
                if($check==null)
                {
                    $p_user = BankPrices::create([
                        'bank_id' => $this->bank_id,
                        'rate_type_id' => $this->rate_type_id,
                        'rate' => $this->rate,
                        'previous_rate' => $this->rate,
                        'current_rate' => $this->rate,
                    ]);
                    $this->clear();
                }
                else
                {
                    $this->addError('submit', 'Already Exist');
                }   
            }
            else
            {
                if($check!=null)
                {
                    $p_user = BankPrices::create([
                        'bank_id' => $this->bank_id,
                        'rate_type_id' => $this->rate_type_id,
                        'rate' => $check->rate,
                        'previous_rate' => $check->current_rate,
                        'current_rate' => $check->current_rate+$this->rate,
                        'change' => $this->rate,
                    ]);
                    $this->clear();
                }
                else
                {
                    $this->addError('submit', 'Rate Does Not Exist');
                }
            }
        }else{
            $this->addError('submit', 'Bank and Rate Type should be selected along with rate');
        }
    }

    public function status_change($id)
    {
        $check = BankPrices::where('id',$id)->first();
        if($check->is_checked==1){
            $check->is_checked = 0;
        }else{
            $check->is_checked = 1;
        }
        $check->save();
        $this->render();
    }

    public function clear(){
        $this->rate_type_id = '';
        $this->rate = '';
        $this->render();
    }
}
