<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Role;
use App\Models\RateType;
use Illuminate\Support\Str;

class ManageRateTypes extends Component
{
    public $rate_type = '';
    public $display_order = '';
    public $update = false;
    public $rate_type_id = '';
    public $update_name = '';
    public $update_display_order = '';

    public function render()
    {
        $data = RateType::orderBy('display_order')->get();
        return view('livewire.manage-rate-types',['data'=>$data,'update'=>$this->update]);
    }

    public function submitForm()
    {
        if($this->rate_type!='' && $this->display_order!='')
        {
            $check = RateType::where('name',$this->rate_type)->orWhere('display_order',$this->display_order)->first();
            if($check == null)
            {
                RateType::create([
                    'name' => $this->rate_type,
                    'display_order' => $this->display_order,
                ]);
                $this->rate_type = '';
                $this->display_order = '';
            }else{
                $this->addError('rate_type', 'Rate Type Already Exists or Display Order is Repeated');
            }
        }else{
            $this->addError('rate_type', 'Rate type Can\'t be Empty');
        }
    }

    public function delete($id){
        RateType::find($id)->delete();
    }

    public function edit($id){
        $this->rate_type_id = $id;
        $this->update_name = RateType::find($id)->name;
        $this->update_display_order = RateType::find($id)->display_order;
        $this->update = true;
    }

    public function update(){
        if($this->update_name!='')
        {
            $check = RateType::where('display_order',$this->update_display_order)->first();
            if($check == null){
                RateType::find($this->rate_type_id)->update([
                    'name' => $this->update_name,
                    'display_order' => $this->update_display_order,
                ]);
                $this->update_name = '';
                $this->update_display_order = '';
                $this->update = false;
            }else{
                if($check->id == $this->rate_type_id){
                    RateType::find($this->rate_type_id)->update([
                        'name' => $this->update_name,
                        'display_order' => $this->update_display_order,
                    ]);
                }else{
                    $this->addError('rate_type', 'Display Order cannot be Repeated ');
                }
            }
        }else{
            $this->addError('update_name', 'Rate type Can\'t be Empty');
        }
        $this->cancel();
    }

    public function cancel(){
        $this->update_name = '';
        $this->update = false;
        $this->user_id = '';
    }
}
