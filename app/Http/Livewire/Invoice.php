<?php

namespace App\Http\Livewire;

use PDF;
use App\Models\CustomerBank;
use App\Models\Contract;
use Livewire\Component;

class Invoice extends Component
{
    public $type = '';
    public $bank = '';
    public $pdt = '';
    public $pdf;

    public function mount($id,$type)
    {
        $this->type = $type;
        $this->bank = CustomerBank::findOrFail($id);
    }

    public function render()
    {
        $reports = Contract::where('bank_id', $this->bank->id)->orderBy('id','desc')->first();
        return view('livewire.invoice',compact('reports'));
    }

    public function download(){
        $reports = Contract::where('bank_id', $this->bank->id)->orderBy('id','desc')->first();
        $this->pdf = PDF::loadView('reports.invoice', compact('reports'))->output();
        return response()->streamDownload(
            fn () => print($this->pdf),
            "Invoice.pdf"
        );
    }

    public function next(){
        return redirect()->route('payment',['id'=>$this->bank->id, 'type'=>$this->type]);
    }
}
