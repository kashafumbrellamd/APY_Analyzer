<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\CustomerBank;
use App\Models\CustomPackageBanks;
use App\Models\Payment;

class ViewDetailedCustomerBank extends Component
{
    public $customerBank;

    public function mount($id){
        $this->customerBank = CustomerBank::with(['contract'])->findOrFail($id);
        $this->customerBank->selected_banks = CustomPackageBanks::join('banks','banks.id','custom_package_banks.customer_selected_bank_id')
            ->join('states','banks.state_id','states.id')
            ->join('cities','banks.city_id','cities.id')
            ->where('bank_id',$id)
            ->select('banks.*','states.name as state_name','cities.name as city_name')
            ->get();
        $this->customerBank->payment = Payment::where('bank_id',$id)->get();
    }

    public function render()
    {
        return view('livewire.view-detailed-customer-bank');
    }
}
