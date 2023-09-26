<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Payment;
use App\Models\CustomPackageBanks;

class RegisteredBanksForApproval extends Component
{
    public function render()
    {
        $data = Payment::where('payment_type','complete')->where('status','0')->get();
        foreach($data as $dt){
            $dt->requested = CustomPackageBanks::where('bank_id',$dt->bank_id)
            ->join('banks','banks.id','custom_package_banks.customer_selected_bank_id')
            ->get();
        }
        return view('livewire.registered-banks-for-approval',compact('data'));
    }


    public function approved($id){
        $payment = Payment::find($id);
        $payment->status = "1";
        $payment->save();
    }
}
