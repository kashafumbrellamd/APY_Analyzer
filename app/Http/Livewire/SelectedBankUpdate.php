<?php

namespace App\Http\Livewire;

use App\Models\Bank;
use App\Models\BankType;
use App\Models\Cities;
use App\Models\Packages;
use App\Models\State;
use App\Models\CustomerBank;
use App\Models\CustomPackageBanks;
use App\Models\Contract;
use App\Models\Role;
use App\Models\User;
use App\Models\BankRequest;
use DB;
use Auth;
use Livewire\Component;

class SelectedBankUpdate extends Component
{
    public $subscription = 'custom';

    public function render()
    {
        $states = State::where('country_id', '233')->get();
        // $this->all_banks = $this->fetch_banks();
        $bank_cities = Cities::get();
        $packages = Packages::get();
        $this->selected_package = Packages::where('package_type',$this->subscription)->first();
        $bank_types = BankType::where('status', 1)->get();
        // $available_states = $this->getStates();
        // $available_cities = $this->getCities();
        // $available_cbsa = $this->getCBSA();
        return view('livewire.selected-bank-update', compact('packages', 'bank_types', 'states', 'bank_cities'));
    }
}
