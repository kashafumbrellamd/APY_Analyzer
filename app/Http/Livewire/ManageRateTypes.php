<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Role;
use App\Models\RateType;
use Illuminate\Support\Str;

class ManageRateTypes extends Component
{
    public $rate_type = '';
    public $update = false;
    public $update_name = '';
    public $edit_info = '';
    public $rate_type_id = '';

    public function render()
    {
        $data = RateType::get();
        return view('livewire.manage-rate-types',['data'=>$data,'update'=>$this->update]);
    }

    public function submitForm()
    {
        if($this->rate_type!='')
        {
            $check = RateType::where('name',$this->rate_type)->first();
            if($check == null)
            {
                RateType::create([
                    'name' => $this->rate_type,
                ]);
                $this->rate_type = '';
                $this->render();
            }else{
                $this->addError('rate_type', 'Rate type Already Exists');
            }
        }else{
            $this->addError('rate_type', 'Rate type Can\'t be Empty');
        }
        $this->rate_type = '';
    }

    public function delete($id){
        RateType::find($id)->delete();
        $this->render();
    }

    public function edit($id){
        $this->rate_type_id = $id;
        $this->update_name = RateType::find($id)->name;
        $this->update = true;
        $this->render();
    }

    public function update(){
        if($this->update_name!='')
        {
            $check = RateType::where('name',$this->update_name)->first();
            if($check == null)
            {
                RateType::find($this->rate_type_id)->update([
                    'name' => $this->update_name,
                ]);
                $this->update_name = '';
                $this->update = false;
                $this->edit_info = '';
                $this->user_id = '';
            }else{
                $this->addError('update_name', 'Rate type Already Exists');
            }
        }else{
            $this->addError('update_name', 'Rate type Can\'t be Empty');
        }
        $this->cancel();
        $this->render();
    }

    public function cancel(){
        $this->update_name = '';
        $this->update = false;
        $this->edit_info = '';
        $this->user_id = '';
        $this->render();
    }
}
