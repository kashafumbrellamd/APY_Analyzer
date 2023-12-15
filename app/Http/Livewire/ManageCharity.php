<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Charity;
use Livewire\WithPagination;

class ManageCharity extends Component
{
    use WithPagination;

    public $charity_name = '';
    public $charity_description = '';
    public $update = false;
    public $update_name = '';
    public $update_description = '';
    public $user_id = '';

    public function render()
    {
        $charities = Charity::paginate(10);
        return view('livewire.manage-charity',['charities'=>$charities]);
    }

    public function submitForm()
    {
        if($this->charity_name!='' && $this->charity_description!='')
        {
            $check = Charity::where('name',$this->charity_name)->first();
            if($check == null)
            {
                Charity::create([
                    'name' => $this->charity_name,
                    'description'=> $this->charity_description,
                ]);
                $this->charity_name = '';
                $this->charity_description = '';
                $this->render();
            }else{
                $this->addError('charity', 'Charity Already Exists');
            }
        }else{
            $this->addError('charity', 'Charity name and Description Can\'t be Empty');
        }
        $this->charity_name = '';
        $this->description = '';
    }

    public function delete($id){
        Charity::find($id)->delete();
        $this->render();
    }

    public function edit($id){
        $this->user_id = $id;
        $this->update_name = Charity::find($id)->name;
        $this->update_des = Charity::find($id)->description;
        $this->update = true;
        $this->render();
    }

    public function update(){
        if($this->update_name!='' && $this->update_des!='')
        {
            Charity::find($this->user_id)->update([
                'name' => $this->update_name,
                'description'=> $this->update_des,
            ]);
            $this->update_name = '';
            $this->update_des = '';
            $this->update = false;
            $this->user_id = '';
        }else{
            $this->addError('update_name', 'Charity name and Description Can\'t be Empty');
        }
        $this->cancel();
        $this->render();
    }

    public function cancel(){
        $this->update_name = '';
        $this->update_des = '';
        $this->update = false;
        $this->user_id = '';
        $this->render();
    }
}
