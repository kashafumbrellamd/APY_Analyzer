<?php

namespace App\Http\Livewire;

use Livewire\WithFileUploads;
use Livewire\Component;
use App\Models\CustomerBank;
use App\Models\Contract;
use App\Models\Payment as Pay;
use Auth;

class Payment extends Component
{
    use WithFileUploads;

    public $bank = '';
    public $amount = '';
    public $photo;
    public $cheque_number = '';
    public $bank_name = '';

    public function mount($id)
    {
        $this->bank = CustomerBank::findOrFail($id);
        $this->amount = Contract::where('bank_id',$id)->first()->charges;
    }

    public function render()
    {
        return view('livewire.payment');
    }

    public function updatedPhoto()
    {
        $this->validate([
            'photo' => 'image|max:1024',
        ]);
    }

    public function submitForm(){
        $path = $this->photo->store('images', 'public');

        $pay = Pay::create([
            'bank_id' => $this->bank->id,
            'cheque_number' => $this->cheque_number,
            'cheque_image' => $path,
            'amount' => $this->amount,
            'bank_name' => $this->bank_name,
            'status' => "0",
        ]);

        if(!Auth::check()){
            return redirect(url('/signin'));
        }else{
            return redirect(url('/home'));
        }
    }
}
