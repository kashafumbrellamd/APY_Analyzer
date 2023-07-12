<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Role;
use App\Models\Bank;
use App\Models\State;
use App\Models\Cities;
use App\Models\BankType;
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
    public $bank_type  = '';
    public $cp_name = '';
    public $cp_email = '';
    public $cp_phone = '';

    public function render()
    {
        $data = Bank::BanksWithStateAndType();
        $states = State::where('country_id','233')->get();
        if($this->state_id != ''){
            $cities = Cities::where('state_id',$this->state_id)->get();
        }else{
            $cities = [];
        }
        $bts = BankType::where('status','1')->get();
        return view('livewire.manage-banks',['data'=>$data,'update'=>$this->update,'states'=>$states,'cities'=>$cities,'bts'=>$bts]);
    }

    public function submitForm()
    {
        if($this->name!='' && $this->state_id!='' && $this->phone_number!='' && $this->website!='' && $this->msa_code!='' && $this->bank_type!='')
        {
            $p_user = Bank::create([
                'name' => $this->name,
                'state_id' => $this->state_id,
                'phone_number' => $this->phone_number,
                'website' => $this->website,
                'city_id' => $this->msa_code,
                'msa_code' => $this->msa_code,
                'bank_type_id' => $this->bank_type,
                'cp_name' => $this->cp_name,
                'cp_email' => $this->cp_email,
                'cp_phone' => $this->cp_phone,
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
        $this->bank_type  = $bank->bank_type_id;
        $this->cp_name = $bank->cp_name;
        $this->cp_email = $bank->cp_email;
        $this->cp_phone = $bank->cp_phone;
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
                'city_id' => $this->msa_code,
                'cp_name' => $this->cp_name,
                'cp_email' => $this->cp_email,
                'cp_phone' => $this->cp_phone,
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
        $this->cp_name = '';
        $this->cp_email = '';
        $this->cp_phone = '';
        $this->update = false;
        $this->render();
    }
}
