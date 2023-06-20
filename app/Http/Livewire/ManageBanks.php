<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Role;
use App\Models\Bank;
use App\Models\State;
use Illuminate\Support\Str;

class ManageBanks extends Component
{
    public $update = false;
    public $bank_id = '';
    public $name = '';
    public $state_id = '';
    public $phone_number = '';
    public $website = '';
    public $msa_code = '';

    public function render()
    {
        $data = Bank::BanksWithState();
        $states = State::where('country_id','233')->get();
        return view('livewire.manage-banks',['data'=>$data,'update'=>$this->update,'states'=>$states]);
    }

    public function submitForm()
    {
        if($this->name!='' && $this->state_id!='' && $this->phone_number!='' && $this->website!='' && $this->msa_code!='')
        {
            $p_user = Bank::create([
                'name' => $this->name,
                'state_id' => $this->state_id,
                'phone_number' => $this->phone_number,
                'website' => $this->website,
                'msa_code' => $this->msa_code,
            ]);
            $this->clear();
        }else{
            $this->addError('submit', 'All fields are required');
        }
    }

    public function delete($id){
        Bank::find($id)->delete();
        $this->clear();
    }

    public function edit($id){
        $bank = Bank::find($id);
        $this->bank_id = $bank->id;
        $this->name = $bank->name;
        $this->state_id = $bank->state_id;
        $this->phone_number = $bank->phone_number;
        $this->website = $bank->website;
        $this->msa_code = $bank->msa_code;
        $this->update = true;
        $this->render();
    }

    public function updateForm(){
        if($this->name!='' && $this->state_id!='' && $this->phone_number!='' && $this->website!='' && $this->msa_code!='')
        {
            Bank::find($this->bank_id)->update([
                'name' => $this->name,
                'state_id' => $this->state_id,
                'phone_number' => $this->phone_number,
                'website' => $this->website,
                'msa_code' => $this->msa_code,
            ]);
            $this->clear();
        }else{
            $this->addError('update_name', 'Role Can\'t be Empty');
        }
    }

    public function cancel(){
        $this->clear();
    }

    public function clear(){
        $this->name = '';
        $this->state_id = '';
        $this->phone_number = '';
        $this->website = '';
        $this->msa_code = '';
        $this->bank_id = '';
        $this->update = false;
        $this->render();
    }
}
