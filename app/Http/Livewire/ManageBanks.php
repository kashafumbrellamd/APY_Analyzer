<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Role;
use App\Models\Bank;
use App\Models\State;
use App\Models\Cities;
use App\Models\BankType;
use Illuminate\Support\Str;
use App\Models\Zip_code;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Response;
use DB;

class ManageBanks extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $update = false;
    public $bank_id = '';
    public $name = '';
    public $state_id = '';
    public $phone_number = '';
    public $website = '';
    public $msa_code = '';
    public $cbsa_code = '';
    public $cbsa_name = '';
    public $zip_code = '';
    public $other_zips = '';

    public $bank_type  = '';
    public $cp_name = '';
    public $cp_email = '';
    public $cp_phone = '';
    public $file = null;
    public $not_inserted_banks = [];

    public $bank_state_filter = '';
    public $bank_city_filter = '';

    public $search = "";

    public function render()
    {
        if($this->search == ""){
            if($this->bank_state_filter != '' && $this->bank_city_filter == ''){
                $data = Bank::ManageBanksWithStateIdAndType($this->bank_state_filter);
            }elseif($this->bank_state_filter == '' && $this->bank_city_filter != ''){
                $data = Bank::ManageBanksWithStateIdAndType('',$this->bank_city_filter);
            }elseif($this->bank_state_filter != '' && $this->bank_city_filter != ''){
                $data = Bank::ManageBanksWithStateIdAndType($this->bank_state_filter,$this->bank_city_filter);
            }else{
                $data = Bank::BanksWithStateAndType();
            }
        }else{
            $query = Bank::join('states', 'banks.state_id', '=', 'states.id')->with('cities')
             ->join('bank_types', 'bank_types.id', '=', 'banks.bank_type_id')
             ->where('banks.name','like','%'.$this->search.'%')
             ->select('banks.*', 'states.name as state_name','bank_types.name as type_name')
             ->orderby('name','ASC');
             if($this->bank_state_filter != ''){
                $query->where('banks.state_id',$this->bank_state_filter);
             }
             if($this->bank_city_filter != ''){
                $query->where('banks.city_id',$this->bank_city_filter);
             }
             $data = $query->paginate(10);
        }
        $states = State::where('country_id','233')->get();
        $cities = Cities::where('country_id','233')->get();
        // $cities = Bank::select('cbsa_name', 'cbsa_code')
        //         ->orderBy('cbsa_name', 'ASC')
        //         ->groupBy('cbsa_name', 'cbsa_code')
        //         ->get();
        $bts = BankType::where('status','1')->get();
        $bank_states = $this->getStates();
        $bank_cities = $this->getCities();
        return view('livewire.manage-banks',['data'=>$data,'update'=>$this->update,'states'=>$states,'cities'=>$cities,'bts'=>$bts,'bank_states'=>$bank_states,'bank_cities'=>$bank_cities]);
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
                'zip_code' => $this->zip_code,
                'other_zips' => $this->other_zips,
                'cbsa_code' => $this->cbsa_code,
                'cbsa_name' => $this->cbsa_name,
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
        $this->zip_code = $bank->zip_code;
        $this->other_zips = $bank->other_zips;
        $this->cbsa_code = $bank->cbsa_code;
        $this->cbsa_name = $bank->cbsa_name;
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
                'zip_code' => $this->zip_code,
                'other_zips' => $this->other_zips,
                'cbsa_code' => $this->cbsa_code,
                'cbsa_name' => $this->cbsa_name,
                'cp_name' => $this->cp_name,
                'cp_email' => $this->cp_email,
                'cp_phone' => $this->cp_phone,
            ]);
            $this->clear();
        }else{
            $this->addError('update_name', 'Role Can\'t be Empty');
        }
    }

    public function download_xlsx()
    {
        $headers = array(
            'Content-Type' => 'text/xlsx'
        );
        $filename =  public_path('BanksDataFormat.xlsx');

        return response()->download($filename, "BanksDataFormat.xlsx", $headers);
    }

    public function upload_xlsx()
    {
        $this->not_inserted_banks = [];
        if($this->file != null)
        {
            $banks = $this->xlsxToArray($this->file->path());
            foreach ($banks as $key => $bank) {
                $bank_check = Bank::where('name',$bank['Bank Name'])->where('cbsa_code',$bank['CBSA Code'])->first();
                if($bank_check==null && $bank['Bank Name']!= null)
                {
                    $zip = Zip_code::where('zip_code',$bank['Zip Code'])->first();
                    if($bank['Bank Type'] == "SMB" || $bank['Bank Type'] == "NMB" || $bank['Bank Type'] == "NAT"){
                        $temp_type = "Bank";
                    }elseif($bank['Bank Type'] == "SAL"){
                        $temp_type = "Saving & Loan";
                    }elseif($bank['Bank Type'] == "SSB" || $bank['Bank Type'] == "FSB"){
                        $temp_type = "Savings Bank";
                    }elseif($bank['Bank Type'] == "SCU" || $bank['Bank Type'] == "FCU"){
                        $temp_type = "Credit Union";
                    }
                    $bank_type = BankType::where('name',$temp_type)->first();
                    if($zip != null && $bank_type != null)
                    {
                        $state_id = State::where('name',$bank['State'])->orwhere('state_code',$bank['State'])->pluck('id')->first();
                        $city_id = Cities::where('name',$bank['City'])->pluck('id')->first();
                        if($state_id!=null && $city_id!=null)
                        {
                                $new_bank = Bank::create([
                                    'name'=>$bank['Bank Name'],
                                    'state_id'=>$state_id,
                                    'phone_number'=>$bank['Phone Number'],
                                    'website'=>$bank['Website'],
                                    'msa_code'=>$city_id,
                                    'city_id'=>$city_id,
                                    'zip_code'=>$bank['Zip Code'],
                                    'other_zips'=>$bank['Other Zip'],
                                    'cbsa_code'=>$bank['CBSA Code'],
                                    'cbsa_name'=>$bank['CBSA Name'],
                                    'cp_name'=>$bank['Contact Person Name'],
                                    'cp_email'=>$bank['Contact Person Email'],
                                    'cp_phone'=>$bank['Contact Person Phone'],
                                    'surveyed'=>$bank['is_surved'],
                                    'bank_type_id'=>$bank_type->id,
                                ]);
                        }
                        else
                        {
                            array_push($this->not_inserted_banks,$bank['Bank Name']);
                        }
                    }
                    else
                    {
                        array_push($this->not_inserted_banks,$bank['Bank Name']);
                    }
                }
            }
            if($this->not_inserted_banks!=[])
            {
                $this->addError('upload_error','Above Banks are not inserted');
            }
            else
            {
                $this->addError('upload_success','All Banks inserted successfully');
            }
            $this->file = null;
        }
        else{
            $this->addError('file_error','Please select file again');
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
        $this->zip_code = '';
        $this->other_zips = '';
        $this->cbsa_code = '';
        $this->cbsa_name = '';
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
        $headerRow = array_shift($rows);

        $data = [];
        foreach ($rows as $row) {
            // Assuming your XLSX file has headers in the first row
            $data[] = array_combine($headerRow, $row);
        }

        return $data;
    }

    public function fetch_zip_code(){
        if (Str::length($this->zip_code) >= 5) {
            $zip = Zip_code::where('zip_code',$this->zip_code)->first();
            if ($zip != null) {
                $this->msa_code = Cities::where('name',$zip->city)->pluck('id')->first();
                $this->state_id = State::where('name',$zip->state)->pluck('id')->first();
            }
        }else{
            $this->msa_code = "";
            $this->state_id = "";
        }
    }

    public function getStates(){
        $state = DB::table('banks')
            ->join('states','states.id','banks.state_id')
            ->select('states.id','states.name')
            ->orderBy('name','ASC')
            ->groupBy('state_id')
            ->get();
        return $state;
    }

    public function getCities()
    {
        if($this->bank_state_filter!='' && $this->bank_state_filter!='all')
        {
            $msa_codes = Bank::select('cbsa_name', 'cbsa_code')
            ->where('banks.state_id',$this->bank_state_filter)
            ->orderBy('cbsa_name', 'ASC')
            ->groupBy('cbsa_name', 'cbsa_code')
            ->get();
            // Bank::with('cities')->where('state_id',$this->bank_state_filter)->groupBy('city_id')->get();
            return $msa_codes;
        }
        else
        {
            // $msa_codes = Bank::with('cities')->groupBy('city_id')->get();
            $msa_codes = Bank::select('cbsa_name', 'cbsa_code')
                ->orderBy('cbsa_name', 'ASC')
                ->groupBy('cbsa_name', 'cbsa_code')
                ->get();
            return $msa_codes;
        }

    }

    public function selectstate($id)
    {
        $this->bank_city_filter = "";
    }

    public function downloadData(){
            if($this->bank_state_filter != '' && $this->bank_city_filter == ''){
                $data = Bank::ToExcelFilteredInsertedData($this->bank_state_filter,'',$this->search);
            }elseif($this->bank_state_filter == '' && $this->bank_city_filter != ''){
                $data = Bank::ToExcelFilteredInsertedData('',$this->bank_city_filter,$this->search);
            }elseif($this->bank_state_filter != '' && $this->bank_city_filter != ''){
                $data = Bank::ToExcelFilteredInsertedData($this->bank_state_filter,$this->bank_city_filter,$this->search);
            }else{
                $data = Bank::ToExcelInsertedData($this->search);
            }

            $spreadsheet = new Spreadsheet();
            $activeWorksheet = $spreadsheet->getActiveSheet();
            $activeWorksheet->setCellValue('A1', 'Id');
            $activeWorksheet->setCellValue('B1', 'Bank Name');
            $activeWorksheet->setCellValue('C1', 'Zip Code');
            $activeWorksheet->setCellValue('D1', 'State');
            $activeWorksheet->setCellValue('E1', 'City');
            $activeWorksheet->setCellValue('F1', 'CBSA Code');
            $activeWorksheet->setCellValue('G1', 'CBSA Name');
            $activeWorksheet->setCellValue('H1', 'Phone Number');
            $activeWorksheet->setCellValue('I1', 'Website');
            $activeWorksheet->setCellValue('J1', 'Institution Type');
            $activeWorksheet->setCellValue('K1', 'Contact Person Name');
            $activeWorksheet->setCellValue('L1', 'Contact Person Email');
            $activeWorksheet->setCellValue('M1', 'Contact Person Phone');
            $activeWorksheet->setCellValue('N1', 'Other Zips');

            $number = 2;
            foreach ($data as $key => $value) {
                $activeWorksheet->setCellValue('A'.$number, $value->id);
                $activeWorksheet->setCellValue('B'.$number, $value->name);
                $activeWorksheet->setCellValue('C'.$number, $value->zip_code);
                $activeWorksheet->setCellValue('D'.$number, $value->state_name);
                $activeWorksheet->setCellValue('E'.$number, $value->cities->name);
                $activeWorksheet->setCellValue('F'.$number, $value->cbsa_code);
                $activeWorksheet->setCellValue('G'.$number, $value->cbsa_name);
                $activeWorksheet->setCellValue('H'.$number, $value->phone_number);
                $activeWorksheet->setCellValue('I'.$number, $value->website);
                $activeWorksheet->setCellValue('J'.$number, $value->type_name);
                $activeWorksheet->setCellValue('K'.$number, $value->cp_name);
                $activeWorksheet->setCellValue('L'.$number, $value->cp_email);
                $activeWorksheet->setCellValue('M'.$number, $value->cp_phone);
                $activeWorksheet->setCellValue('N'.$number, $value->other_zips);
                $number++;
            }

            $writer = new Xlsx($spreadsheet);

            $headers = [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="Banks_Data.xlsx"',
            ];

            $callback = function () use ($writer) {
                $writer->save('php://output');
            };

            return Response::stream($callback, 200, $headers);
    }
}
