<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\BankType as BT;
use Livewire\WithPagination;

class BankType extends Component
{
    use WithPagination;

    protected $rules = [
        'name'=>'required',
        'status'=>'required',
    ];

    public $bt_id = false;
    public $name;
    public $status = '1';
    public $update;

    public function render()
    {
        $data = BT::paginate(10);
        return view('livewire.bank-type',['data'=>$data]);
    }

    public function submitForm(){
        $this->validate();
        $bt = BT::create([
            'name' => $this->name,
            'status' => $this->status,
        ]);
        $this->clear();
        $this->render();
    }


    public function edit($id){
        $bt = BT::find($id);
        $this->name = $bt->name;
        $this->status = $bt->status;
        $this->bt_id = $id;
        $this->update = true;
        $this->render();
    }

    public function updateForm(){
        BT::find($this->bt_id)->update([
            'name' => $this->name,
            'status' => $this->status,
        ]);
        $this->clear();
    }

    public function delete($id){
        BT::find($id)->delete();
        $this->render();
    }

    public function clear(){
        $this->name = '';
        $this->status = '1';
        $this->update = false;
    }
}
