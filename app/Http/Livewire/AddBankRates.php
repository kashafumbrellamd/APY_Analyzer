<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\RateType;
use App\Models\Bank;
use App\Models\BankPrices;
use App\Models\State;
use App\Models\SpecializationRates;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use PhpOffice\PhpSpreadsheet\IOFactory;
use DB;

class AddBankRates extends Component
{
    use WithFileUploads;

    public $update = false;
    public $bank_id = '';
    public $bank = '';
    public $state_name = '';
    public $rate = '';
    public $rate_type_id = '';
    public $special_rate = '';
    public $special_description = '';
    public $file = null;
    public $spec_file = null;
    public $not_inserted_banks = [];
    public $not_inserted_rt = [];

    public function render()
    {
        $data = Bank::BanksWithState();
        $rate_types = RateType::orderBy('display_order')->get();
        $bank_prices = BankPrices::BankPricesWithType($this->bank_id);
        $special_prices = SpecializationRates::specialPricesWithBankId($this->bank_id);
        return view('livewire.add-bank-rates',
                        ['data'=>$data,'bank_prices'=>$bank_prices,
                        'update'=>$this->update,'rate_types'=>$rate_types,'special_prices'=>$special_prices]);
    }

    public function onbankselect($id)
    {
        $this->bank_id = $id;
        if($id!=0)
        {
            $this->bank = Bank::find($id);
            $state = State::find($this->bank->state_id);
            $this->state_name = $state->name;
        }
        else
        {
            $this->bank = '';
            $this->state_name = '';
        }
        $this->rate_type_id = '';
        $this->render();
    }

    public function submitForm()
    {
        if($this->bank_id!='' && $this->rate_type_id!='' && $this->rate!='' && $this->bank_id!=0)
        {
            $check = BankPrices::where('bank_id',$this->bank_id)->where('rate_type_id',$this->rate_type_id)
            ->orderby('id','DESC')->first();
            if(auth()->user()->hasRole('admin'))
            {
                if($check==null)
                {
                    $p_user = BankPrices::create([
                        'bank_id' => $this->bank_id,
                        'rate_type_id' => $this->rate_type_id,
                        'rate' => $this->rate,
                        'previous_rate' => $this->rate,
                        'current_rate' => $this->rate,
                    ]);
                    $this->clear();
                }
                else
                {
                    $this->addError('submit', 'Already Exist');
                }
            }
            else
            {
                if($check!=null)
                {
                    $p_user = BankPrices::create([
                        'bank_id' => $this->bank_id,
                        'rate_type_id' => $this->rate_type_id,
                        'rate' => $check->rate,
                        'previous_rate' => $check->current_rate,
                        'current_rate' => $this->rate,
                        'change' => $this->rate-$check->current_rate,
                    ]);
                    $this->clear();
                }
                else
                {
                    $this->addError('submit', 'Rate Does Not Exist');
                }
            }
        }else{
            $this->addError('submit', 'Bank and Rate Type should be selected along with rate');
        }
    }

    public function specialRateSubmit(){
        if ($this->special_rate != '' && $this->special_description != '') {
                $p_user = SpecializationRates::create([
                    'bank_id' => $this->bank_id,
                    'rate' => $this->special_rate,
                    'description' => $this->special_description,
                ]);
            $this->clear();
        } else {
            $this->addError('s_submit', 'Bank and Rate Type should be selected along with rate');
        }
    }

    public function status_change($id)
    {
        $check = BankPrices::where('id',$id)->first();
        if($check->is_checked==1){
            $check->is_checked = 0;
        }else{
            $check->is_checked = 1;
        }
        $check->save();
        $this->render();
    }

    public function deleteSpecRate($id){
        SpecializationRates::find($id)->delete();
        $this->render();
    }

    public function download_xlsx()
    {
        $headers = array(
            'Content-Type' => 'text/xlsx'
        );
        $filename =  public_path('BankRates.xlsx');

        return response()->download($filename, "BankRates.xlsx", $headers);
    }

    public function download_special_xlsx()
    {
        $headers = array(
            'Content-Type' => 'text/xlsx'
        );
        $filename =  public_path('BankRates(special).xlsx');

        return response()->download($filename, "BankRates(special).xlsx", $headers);
    }

    public function upload_xlsx()
    {
        $this->not_inserted_banks = [];
        $this->not_inserted_rt = [];
        if($this->file != null)
        {
            $head = $this->xlsxToArray($this->file->path());
            $data = $head['file'];
            $head = $head['headerRow'];
            foreach ($data as $key => $dt) {
                $bank = Bank::where('id',$dt['Id'])->first();
                if($bank!=null)
                {
                    $date = date('Y-m-d H:i:s',strtotime($dt['Date (mm/dd/YYYY)']));
                    foreach ($head as $key => $hd) {
                        if($hd!=null && $hd!='Id' && $hd != 'Bank Name'
                        && $hd!='State' && $hd!='Phone Number'
                        && $hd!='Website' && $hd!='Institution Type'
                        && $hd!='Contact Person Name' && $hd!='Contact Person Email' && $hd != 'Contact Person Phone'
                        && $hd!='Date (mm/dd/YYYY)' && $hd!=null){
                            $rt = RateType::where('name',$hd)->first();
                            if($rt!=null)
                            {
                                $check = BankPrices::where('bank_id',$bank->id)->where('rate_type_id',$rt->id)->orderby('id','DESC')->first();
                                if($check==null){
                                    $p_user = DB::table('bank_prices')->insertGetID([
                                        'bank_id' => $bank->id,
                                        'rate_type_id' => $rt->id,
                                        'rate' => $dt[$hd],
                                        'previous_rate' => $dt[$hd],
                                        'current_rate' => $dt[$hd],
                                        'change' => 0,
                                        'is_checked' => 1,
                                        'created_at' => $date,
                                        'updated_at' => $date,
                                    ]);
                                }else{
                                    $p_user = DB::table('bank_prices')->insertGetID([
                                        'bank_id' => $bank->id,
                                        'rate_type_id' => $rt->id,
                                        'rate' => $check->rate,
                                        'previous_rate' => $check->current_rate,
                                        'current_rate' => $dt[$hd],
                                        'change' => $dt[$hd]-$check->current_rate,
                                        'is_checked' => 1,
                                        'created_at' => $date,
                                        'updated_at' => $date,
                                    ]);
                                }
                            }else{
                                array_push($this->not_inserted_rt,$hd);
                            }
                        }
                    }
                }else{
                    array_push($this->not_inserted_banks,$dt['Bank Name']);
                }
            }

            if($this->not_inserted_banks == [] && $this->not_inserted_rt == []){
                $this->addError('upload_success','All Data inserted successfully');
            }else{
                if($this->not_inserted_banks != []){
                    $this->addError('upload_error','Above Banks Does not exist');
                }
                if($this->not_inserted_rt != []){
                    $this->addError('upload_rt_error','Above Columns does not exist and their data is not inserted');
                }
            }
            $this->file = null;
        }
        else{
            $this->addError('file_error','Please select file again');
        }
    }

    public function upload_special_xlsx()
    {
        $this->not_inserted_banks = [];
        $this->not_inserted_rt = [];
        if($this->spec_file != null)
        {
            $head = $this->xlsxToArray($this->spec_file->path());
            $data = $head['file'];
            $head = $head['headerRow'];
            foreach ($data as $key => $dt) {
                $bank = Bank::where('id',$dt['Id'])->first();
                if($bank!=null)
                {
                    $date = date('Y-m-d H:i:s',strtotime($dt['Date (mm/dd/YYYY)']));
                    if($dt['Rate']!=null)
                    {
                        $p_user = DB::table('specialization_rates')->insert([
                            'bank_id' => $bank->id,
                            'rate' => $dt['Rate'],
                            'description' => $dt['Description'],
                            'created_at' => $date,
                            'updated_at' => $date,
                        ]);
                    }
                    else{
                        array_push($this->not_inserted_rt,$dt['Bank Name']);
                    }
                }else{
                    array_push($this->not_inserted_banks,$dt['Bank Name']);
                }
            }

            if($this->not_inserted_banks == [] && $this->not_inserted_rt == []){
                $this->addError('upload_spec_success','All Data inserted successfully');
            }else{
                if($this->not_inserted_banks != []){
                    $this->addError('upload_spec_error','Above Banks Does not exist');
                }
                if($this->not_inserted_rt != []){
                    $this->addError('upload_spec_rt_error','Above Banks Rate are null');
                }
            }
            $this->spec_file = null;
        }
        else{
            $this->addError('spec_file_error','Please select file again');
        }
    }

    public function clear(){
        $this->rate_type_id = '';
        $this->rate = '';
        $this->special_rate = '';
        $this->special_description = '';
        $this->render();
    }

    function xlsxToArray($filePath)
    {
        if (!file_exists($filePath) || !is_readable($filePath)){
            return false;
        }
        $spreadsheet = IOFactory::load($filePath);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();

        // Remove the header row if needed
        $data['headerRow'] = array_shift($rows);

        $data['file'] = [];
        foreach ($rows as $row) {
            // Assuming your XLSX file has headers in the first row
            $data['file'][] = array_combine($data['headerRow'], $row);
        }

        return $data;
    }


}
