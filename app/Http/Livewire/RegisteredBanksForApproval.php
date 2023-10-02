<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Payment;
use App\Models\CustomPackageBanks;
use App\Models\BankSelectedCity;
use App\Models\CustomerBank;

class RegisteredBanksForApproval extends Component
{
    public function render()
    {
        $data = Payment::where('payment_type','complete')->where('status','0')->get();
        foreach($data as $dt){
            $bank = CustomerBank::find($dt->bank_id);
            $dt->display_reports = $bank->display_reports;
            if($bank->display_reports == 'custom'){
                $dt->requested = CustomPackageBanks::where('bank_id',$dt->bank_id)
                ->join('banks','banks.id','custom_package_banks.customer_selected_bank_id')
                ->get();
            }elseif($bank->display_reports == 'state'){
                $dt->requested = BankSelectedCity::where('bank_id',$dt->bank_id)
                ->join('cities','cities.id','bank_selected_city.city_id')
                ->get();
            }
        }
        return view('livewire.registered-banks-for-approval',compact('data'));
    }


    public function approved($id){
        $payment = Payment::find($id);
        $payment->status = "1";
        $payment->save();
    }
}
