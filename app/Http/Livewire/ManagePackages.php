<?php

namespace App\Http\Livewire;

use App\Models\Packages;
use Livewire\Component;

class ManagePackages extends Component
{
    public $name = '';
    public $price = '';
    public $additional_price = '';
    public $description = '';
    public $number_of_units = '';
    public $package_type = '';
    public $package_id = '';
    public $update = false;

    protected $rules = [
        'name'=>'required',
        'price' => 'required',
        'additional_price' => 'required',
        'description' => 'required',
        'number_of_units' => 'required',
    ];
    public function render()
    {
        $packages = Packages::paginate(10);
        return view('livewire.manage-packages',compact('packages'));
    }

    public function submitForm(){
        $this->validate();
        $bt = Packages::create([
            'name'=> $this->name,
            'price' => $this->price,
            'additional_price' => $this->additional_price,
            'description' => $this->description,
            'number_of_units' => $this->number_of_units,
            'package_type' => $this->package_type,
        ]);
        $this->clear();
        $this->render();
    }

    public function edit($id){
        $packages = Packages::find($id);
        $this->name = $packages->name;
        $this->price = $packages->price;
        $this->additional_price = $packages->additional_price;
        $this->description = $packages->description;
        $this->number_of_units = $packages->number_of_units;
        $this->package_type = $packages->package_type;
        $this->package_id = $id;
        $this->update = true;
        $this->render();
    }

    public function updateForm(){
        Packages::find($this->package_id)->update([
            'name'=> $this->name,
            'price' => $this->price,
            'additional_price' => $this->additional_price,
            'description' => $this->description,
            'number_of_units' => $this->number_of_units,
            'package_type' => $this->package_type,
        ]);
        $this->clear();
    }

    public function delete($id){
        Packages::find($id)->delete();
        $this->render();
    }

    public function clear(){
        $this->name = '';
        $this->price = '';
        $this->additional_price = '';
        $this->description = '';
        $this->number_of_units = '';
        $this->package_id = '';
        $this->package_type = '';
        $this->update = false;
    }


}
