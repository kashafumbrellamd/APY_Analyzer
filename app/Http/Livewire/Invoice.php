<?php

namespace App\Http\Livewire;

use PDF;
use App\Models\CustomerBank;
use App\Models\Contract;
use App\Models\User;
use Livewire\Component;
use Auth;

class Invoice extends Component
{
    public $type = '';
    public $bank = '';
    public $pdt = '';
    public $pdf;
    public $tandc = false;

    public function mount($id,$type)
    {
        $this->type = $type;
        $this->bank = CustomerBank::findOrFail($id);
    }

    public function render()
    {
        $reports = Contract::where('bank_id', $this->bank->id)->orderBy('id','desc')->first();
        $bank = $this->bank;
        $user = User::where('bank_id', $this->bank->id)->first();
        return view('livewire.invoice',compact('reports','bank','user'));
    }

    public function download(){
        $reports = Contract::where('bank_id', $this->bank->id)->orderBy('id','desc')->first();
        $bank = $this->bank;
        $this->pdf = PDF::loadView('reports.invoice', compact('reports','bank'))->output();
        return response()->streamDownload(
            fn () => print($this->pdf),
            "Invoice.pdf"
        );
    }

    public function next(){
        if($this->tandc){
            if($this->bank->display_reports == "custom"){
                return redirect()->route('payment',['id'=>$this->bank->id, 'type'=>$this->type]);
            }else{
                if(!Auth::check()){
                    return redirect(url('/signin'));
                }else{
                    return redirect(url('/home'));
                }
            }
        }
    }
}
