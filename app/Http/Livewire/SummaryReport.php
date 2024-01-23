<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\RateType;
use App\Models\BankPrices;
use App\Models\Bank;
use App\Models\CustomerBank;
use App\Models\BankType;
use App\Models\Filter;
use App\Models\Column;
use App\Models\BankSelectedCity;
use App\Models\CustomPackageBanks;


class SummaryReport extends Component
{
    public $columns = [];
    public $last_updated = '';
    public $selected_bank = '';
    public $selected_bank_type = [];
    public $my_bank_id = '';
    public $unique = false;

    public function render()
    {
        $rt = RateType::orderby('display_order')->get();
        $bankTypes = BankType::where('status','1')->get();
        if($this->selected_bank_type == [])
        {
            $this->fill_type($bankTypes);
        }
        foreach ($rt as $key => $value) {
            $data = BankPrices::summary_report($value->id,$this->selected_bank_type,$this->unique);
            $value->data = $data;
        }
        $this->last_updated = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', BankPrices::max('updated_at'))->format('m-d-Y');
        if($this->columns == [])
        {
            $this->fill($rt);
        }
        $customer_bank = CustomerBank::where('id',auth()->user()->bank_id)->first();
        $this->my_bank_id = Bank::where('name','like','%'.$customer_bank->bank_name.'%')->pluck('id')->first();
        if($customer_bank->display_reports == "custom"){
            $banks = CustomPackageBanks::where('bank_id',auth()->user()->bank_id)
            ->join('banks','banks.id','custom_package_banks.customer_selected_bank_id')
            ->select('banks.*')
            ->get();
        }elseif($customer_bank->display_reports == "state"){
            $cities = BankSelectedCity::where('bank_id',auth()->user()->bank_id)->pluck('city_id')->toArray();
            // if($this->unique){
            //     $banks = Bank::whereIn('city_id',$cities)->groupBy('banks.name')->get();
            // }else{
            //     $banks = Bank::whereIn('city_id',$cities)->get();
            // }
            $banks = Bank::whereIn('cbsa_code',$cities)->get();
        }else{
            $banks = Bank::get();
        }
        return view('livewire.summary-report',['rate_type'=>$rt,'banks'=>$banks,'bankTypes'=>$bankTypes,'customer_bank'=>$customer_bank]);
    }

    public function fill($data)
    {
        foreach ($data as $key => $dt) {
            $this->columns[$dt->id] = 1;
        }
    }

    public function check_column($id)
    {
        if($this->columns[$id] == 1){
            $this->columns[$id] = 0;
        }else{
            $this->columns[$id] = 1;
        }
    }

    public function selectAll(){
        foreach ($this->columns as $key => $dt) {
                $this->columns[$key] = 1;
        }
        $this->render();
    }

    public function deselectAll(){
        foreach ($this->columns as $key => $dt) {
                $this->columns[$key] = 0;
        }
        $this->render();
    }

    public function save_filters()
    {
        $user_id = auth()->user()->id;
        if($this->selected_bank == '' && $this->selected_bank_type == '' && $this->columns == []){
            $this->addError('filter_error','No Filter is Selected');
        }else{
            $colum = Column::where('user_id',$user_id)->delete();
            foreach ($this->columns as $key => $value) {
                if($value==1){
                    $colum = Column::Create([
                        'user_id'=>$user_id,
                        'rate_type_id'=>$key,
                    ]);
                }
            }
            $filters = Filter::where('user_id',$user_id)->first();
            if($filters!=null){
                $filters->bank_type_id = $this->selected_bank_type;
                $filters->bank_id = $this->selected_bank;
                $filters->save();
                $this->addError('filter_success','Filters Updated Successfully');
            }else{
                $filters = Filter::Create([
                    'user_id'=>$user_id,
                    'bank_type_id'=>$this->selected_bank_type,
                    'bank_id'=>$this->selected_bank,
                ]);
                $this->addError('filter_success','Filters Added Successfully');
            }
        }
    }

    public function load_filters()
    {
        $user_id = auth()->user()->id;
        $colum = Column::where('user_id',$user_id)->get();
        $filters = Filter::where('user_id',$user_id)->first();
        if($filters!=null)
        {
            $this->deselectAll();
            foreach ($colum as $col) {
                $index = $col->rate_type_id;
                $this->columns[$index] = 1;
            }
            $this->selected_bank_type = $filters->bank_type_id;
            $this->selected_bank = $filters->bank_id;
        }
        else{
            $this->addError('filter_error','No Filter is saved');
        }
    }

    public function clear_filer(){
        $this->selected_bank = '';
        $this->selected_bank_type = [];
    }

    public function fill_type($data)
    {
        foreach ($data as $key => $dt) {
            array_push($this->selected_bank_type,$dt->id);
        }
    }

    public function deselectAllInstituteType(){
        $this->selected_bank_type = [""];
    }

    public function selectAllInstituteType(){
        $this->selected_bank_type = [];
    }
}
