<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Cities;
use App\Models\Bank;
use App\Models\StandardReportList;
use Livewire\WithPagination;

class StandardMetropolitanArea extends Component
{
    use WithPagination;

    public $name;
    public $city_id = "";

    public $update = false;
    public $update_id;


    public function render()
    {
        $cities = Bank::select('cbsa_name', 'cbsa_code')
            ->orderBy('cbsa_name', 'ASC')
            ->groupBy('cbsa_name', 'cbsa_code')
            ->get();
        $data = StandardReportList::with('cbsa')->paginate(10);
        return view('livewire.standard-metropolitan-area',['cities'=>$cities,'data'=>$data]);
    }

    public function submitForm()
    {
        if($this->name!='' && $this->city_id != '')
        {
            $check = StandardReportList::where('name',$this->name)->where('city_id',$this->city_id)->first();
            if($check == null)
            {
                StandardReportList::create([
                    'name' => $this->name,
                    'city_id' => $this->city_id,
                    'status' => "1",
                ]);
                $this->clear();
            }else{
                $this->addError('report', 'Report Already Exists');
            }
        }else{
            $this->addError('report', 'Name or City Can\'t be Empty');
        }
    }

    public function delete($id){
        StandardReportList::find($id)->delete();
    }

    public function edit($id){
        $this->update_id = $id;
        $this->update = true;
        $this->name = StandardReportList::find($id)->name;
        $this->city_id = StandardReportList::find($id)->city_id;
    }

    public function update(){
        if($this->name!='' && $this->city_id != '')
        {
            StandardReportList::find($this->update_id)->update([
                'name' => $this->name,
                'city_id' => $this->city_id,
                'status' => "1",
            ]);
        }else{
            $this->addError('update_name', 'Name or City can\'t be Empty');
        }
        $this->cancel();
        $this->render();
    }

    public function cancel(){
        $this->update = false;
        $this->name = '';
        $this->city_id = '';
        $this->update_id = '';
    }


    public function clear(){
        $this->name = '';
        $this->city_id = '';
    }
}
