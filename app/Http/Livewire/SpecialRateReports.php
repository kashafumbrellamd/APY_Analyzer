<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\SpecializationRates;

class SpecialRateReports extends Component
{
    public function render()
    {
        $specialization_rates = SpecializationRates::with('bank')->get();
        return view('livewire.special-rate-reports', ['specialization_rates'=>$specialization_rates]);
    }
}
