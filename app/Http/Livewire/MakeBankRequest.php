<?php

namespace App\Http\Livewire;

use App\Models\State;
use App\Models\Cities;
use App\Models\Zip_code;
use App\Models\BankRequest;
use Livewire\Component;
use Str;
use Livewire\WithPagination;

class MakeBankRequest extends Component
{
    use WithPagination;

    protected $rules = [
        'name' => 'required',
        'zip_code' => 'required',
        'state_id' => 'required',
        'city_id' => 'required',
    ];

    public $name;
    public $zip_code;
    public $state_id;
    public $city_id;
    public $description;

    public function render()
    {
        $states = State::where('country_id','233')->get();
        $cities = Cities::get();
        $data = BankRequest::with('state','cities')
            ->join('users','bank_requests.user_id','users.id')
            ->join('customer_bank','customer_bank.id','users.bank_id')
            ->select('bank_requests.*','customer_bank.id as customer_bank_id','customer_bank.bank_name as customer_bank_name')
            ->paginate(10);
        return view('livewire.make-bank-request',['data'=>$data, 'states'=>$states, 'cities'=>$cities]);
    }

    public function fetch_zip_code(){
        if (Str::length($this->zip_code) >= 5) {
            $zip = Zip_code::where('zip_code',$this->zip_code)->first();
            if ($zip != null) {
                $this->city_id = Cities::where('name',$zip->city)->pluck('id')->first();
                $this->state_id = State::where('name',$zip->state)->pluck('id')->first();
            }
        }else{
            $this->city_id = "";
            $this->state_id = "";
        }
    }

    public function submitForm()
    {
        $this->validate();
        $p_user = BankRequest::create([
            'name' => $this->name,
            'state_id' => $this->state_id,
            'city_id' => $this->city_id,
            'zip_code' => $this->zip_code,
            'description' => $this->description,
            'user_id' => auth()->user()->id,
        ]);
        session()->flash('message', 'Request Made successfully.');
        $this->clear();
    }

    public function clear(){
        $this->name = "";
        $this->state_id = "";
        $this->city_id = "";
        $this->zip_code = "";
        $this->description = "";
    }
}
