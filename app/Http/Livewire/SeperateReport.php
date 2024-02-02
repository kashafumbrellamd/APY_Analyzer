<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Bank;
use App\Models\BankPrices;
use App\Models\CustomerBank;
use App\Models\CustomPackageBanks;
use App\Models\User;
use App\Models\State;
use App\Models\Role;
use App\Models\Filter;
use App\Models\Column;
use App\Models\RateType;
use App\Models\BankType;
use DB;
use PDF;

class SeperateReport extends Component
{

    public $columns = [];
    public $reports;
    public $results;
    public $state_id = "";
    public $msa_code = "";
    public $last_updated = "";
    public $selected_bank = "";
    public $selected_bank_type = [];
    public $my_bank_id = "";
    public $unique = false;

    public function render()
    {
        $rt = RateType::orderby('display_order')->get();
        $customer_type = CustomerBank::where('id',auth()->user()->bank_id)->first();
        // if($this->unique){
        //     if($customer_type->display_reports == "custom"){
        //         $this->unique = false;
        //     }elseif($customer_type->display_reports == "state"){
        //         $this->unique = true;
        //     }
        // }
        $states = $this->getstates();
        $msa_codes = $this->getmsacodes();
        $bankTypes = BankType::where('status','1')->get();
        if($this->selected_bank_type == [])
        {
            $this->fill_type($bankTypes);
        }
        $this->last_updated = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', BankPrices::max('updated_at'))->format('m-d-Y');
        if($this->state_id!="" && $this->state_id!='all'){
            $response = BankPrices::SeperateReports('state',$this->state_id,$this->msa_code,$this->selected_bank_type,$this->unique);
            $this->reports = $response['rate_types'];
            $this->results = BankPrices::get_min_max_func('state',$this->state_id,$this->msa_code,$this->selected_bank_type);
        }elseif ($this->msa_code != "" && $this->msa_code!='all') {
            $response = BankPrices::SeperateReports('msa','all',$this->msa_code,$this->selected_bank_type,$this->unique);
            $this->reports = $response['rate_types'];
            $this->results = BankPrices::get_min_max_func('msa','all',$this->msa_code,$this->selected_bank_type);
        }else {
            $response = BankPrices::SeperateReports('all','all','0',$this->selected_bank_type,$this->unique);
            $this->reports = $response['rate_types'];
            $this->results = BankPrices::get_min_max_func('all','all','0',$this->selected_bank_type);
        }
        if($this->columns == [])
        {
            $this->fill($rt);
        }
        $banks = $response['show_banks'];
        $my_bank_name = CustomerBank::where('id',auth()->user()->bank_id)->pluck('bank_name')->first();
        $this->my_bank_id = Bank::where('name','like','%'.$my_bank_name.'%')->pluck('id')->first();
        return view('livewire.seperate-report',['customer_type'=>$customer_type,'states'=>$states,'msa_codes'=>$msa_codes,'bankTypes'=>$bankTypes,'banks'=>$banks]);
    }

    public function fill($data)
    {
        foreach ($data as $key => $dt) {
            $this->columns[$dt->id] = 1;
        }
    }

    public function fill_type($data)
    {
        foreach ($data as $key => $dt) {
            array_push($this->selected_bank_type,$dt->id);
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

    public function getstates()
    {
        $selected_banks = CustomPackageBanks::where('bank_id',auth()->user()->bank_id)
        ->join('banks', 'custom_package_banks.customer_selected_bank_id', '=', 'banks.id')
        ->pluck('banks.state_id')->toArray();
        $states = State::whereIn('id',$selected_banks)->get();
        // $states = Bank::join('states', 'banks.state_id', '=', 'states.id')
        // ->select('states.*')
        // ->groupBy('states.id')
        // ->get();
        return $states;
    }

    public function getmsacodes()
    {
        if($this->state_id!='' && $this->state_id!='all')
        {
            $msa_codes = Bank::with('cities')->where('state_id',$this->state_id)->groupBy('city_id')->get();
            return $msa_codes;
        }
        else
        {
            $customer_type = CustomerBank::where('id',auth()->user()->bank_id)->first();
            if($customer_type->display_reports == 'state'){
                $banks_city = DB::table('bank_selected_city')->where('bank_id',auth()->user()->bank_id)->pluck('city_id')->toArray();
                $msa_codes = Bank::with('cities')->whereIn('cbsa_code',$banks_city)->groupBy('cbsa_code')->get();
                return $msa_codes;
            }elseif($customer_type->display_reports == 'custom'){
                $msa_codes = Bank::with('cities')->groupBy('city_id')->get();
                return $msa_codes;
            }
        }

    }

    public function selectAll(){
        foreach ($this->columns as $key => $dt) {
                $this->columns[$key] = 1;
        }
    }

    public function deselectAll(){
        foreach ($this->columns as $key => $dt) {
                $this->columns[$key] = 0;
        }
    }

    public function deselectAllInstituteType(){
        $this->selected_bank_type = [""];
    }

    public function selectAllInstituteType(){
        $this->selected_bank_type = [];
    }

    public function print_report()
    {
        $rt = RateType::orderby('display_order')->get();
        if($this->state_id!='' && $this->state_id!='all'){
            $response = BankPrices::SeperateReports('state',$this->state_id,$this->msa_code,$this->selected_bank_type,$this->unique);
            $reports = $response['rate_types'];
            $results = BankPrices::get_min_max_func('state',$this->state_id,$this->msa_code,$this->selected_bank_type);
        }elseif ($this->msa_code != '' && $this->msa_code!='all') {
            $response = BankPrices::SeperateReports('msa','all',$this->msa_code,$this->selected_bank_type,$this->unique);
            $reports = $response['rate_types'];
            $results = BankPrices::get_min_max_func('msa','all',$this->msa_code,$this->selected_bank_type);
        }else {
            $response = BankPrices::SeperateReports('all','all','0',$this->selected_bank_type,$this->unique);
            $reports = $response['rate_types'];
            $results = BankPrices::get_min_max_func('all','all','0',$this->selected_bank_type);
        }
        if($this->columns == [])
        {
            $this->fill($rt);
        }
        $columns = $this->columns;
        $msa_codes = $this->getmsacodes();

        $pdf = PDF::loadView('reports.seperate_report_pdf', compact('reports','results','columns','msa_codes'))
            ->set_option("isPhpEnabled", true)
            ->setPaper('a4')
            ->output();

        // return response()->streamDownload(
        //     fn () => print($pdf),
        //     "Seperate_Report.pdf"
        // );
        return response()->streamDownload(
            function () use ($pdf, $msa_codes) {
                print($pdf);
            },
            "Seperate_Report.pdf"
        );
        $this->render();
    }

    public function clear()
    {
        $this->state_id = "";
        $this->msa_code = "";
        $this->selected_bank_type = [];
        $this->selected_bank = "";
    }

    public function selectstate($id)
    {
        $this->msa_code = "";
    }

    public function save_filters()
    {
        $user_id = auth()->user()->id;
        if($this->state_id == '' && $this->msa_code == '' && $this->selected_bank_type == '' && $this->selected_bank == '' && $this->columns == []){
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
                $filters->state_id = $this->state_id;
                $filters->city_id = $this->msa_code;
                $filters->bank_type_id = $this->selected_bank_type;
                $filters->bank_id = $this->selected_bank;
                $filters->save();
                $this->addError('filter_success','Filters Updated Successfully');
            }else{
                $filters = Filter::Create([
                    'user_id'=>$user_id,
                    'state_id'=>$this->state_id,
                    'city_id'=>$this->msa_code,
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
            $this->state_id = $filters->state_id;
            $this->msa_code = $filters->city_id;
            $this->selected_bank_type = $filters->bank_type_id;
            $this->selected_bank = $filters->bank_id;
        }
        else{
            $this->addError('filter_error','No Filter is saved');
        }
    }
}
