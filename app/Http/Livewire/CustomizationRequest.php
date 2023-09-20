<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Payment;
use App\Models\CustomPackageBanks;
use DB;
use Auth;

class CustomizationRequest extends Component
{
    public function render()
    {
        $data = Payment::where('payment_type','partial')->where('status','0')->get();
        foreach($data as $dt){
            if($dt->bank_name == "null"){
                $dt->bank_name = DB::table('customer_bank')->where('id',$dt->bank_id)->pluck('bank_name')->first();
            }
            $dt->request_banks = DB::table('temp_custom_bank')->where('bank_id',$dt->bank_id)->get();
        }
        return view('livewire.customization-request',compact('data'));
    }

    public function approved($id){
        $payment = Payment::find($id);
        $request_banks = DB::table('temp_custom_bank')->where('bank_id',$payment->bank_id)->get();
        foreach ($request_banks as $key => $value) {
            if($value->type == "remove"){
                CustomPackageBanks::where('bank_id',$payment->bank_id)
                    ->where('customer_selected_bank_id',$value->customer_selected_bank_id)->delete();
            }else{
                CustomPackageBanks::create([
                    'bank_id' => $payment->bank_id,
                    'customer_selected_bank_id' => $value->customer_selected_bank_id,
                ]);
            }
        }
        $payment->status = "1";
        $payment->save();
        DB::table('temp_custom_bank')->where('bank_id',$payment->bank_id)->delete();

    }
}
