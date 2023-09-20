<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Payment;

class RegisteredBanksForApproval extends Component
{
    public function render()
    {
        $data = Payment::where('payment_type','complete')->where('status','0')->get();
        return view('livewire.registered-banks-for-approval',compact('data'));
    }


    public function approved($id){
        $payment = Payment::find($id);
        $payment->status = "1";
        $payment->save();
    }
}
