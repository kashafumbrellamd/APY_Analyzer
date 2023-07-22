<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Role;
use App\Models\Bank;
use App\Models\State;
use App\Models\Cities;
use App\Models\BankType;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ManageBanks extends Component
{
    use WithFileUploads;

    public $update = false;
    public $bank_id = '';
    public $name = '';
    public $state_id = '';
    public $phone_number = '';
    public $website = '';
    public $msa_code = '';
    public $bank_type  = '';
    public $cp_name = '';
    public $cp_email = '';
    public $cp_phone = '';
    public $file = null;
    public $not_inserted_banks = [];

    public function render()
    {
        $data = Bank::BanksWithStateAndType();
        $states = State::where('country_id','233')->get();
        if($this->state_id != ''){
            $cities = Cities::where('state_id',$this->state_id)->get();
        }else{
            $cities = [];
        }
        $bts = BankType::where('status','1')->get();
        return view('livewire.manage-banks',['data'=>$data,'update'=>$this->update,'states'=>$states,'cities'=>$cities,'bts'=>$bts]);
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
                $bank_check = Bank::where('name',$bank['Bank Name'])->first();
                if($bank_check==null)
                {
                    $bank_state = State::where('name',$bank['State'])->where('country_id',233)->first();
                    $bank_city = Cities::where('name',$bank['City'])->first();
                    $bank_type = BankType::where('name',$bank['Bank Type'])->orWhere('state_code',$bank['Bank Type'])->first();
                    if($bank_state != null && $bank_city != null && $bank_type != null)
                    {
                        $new_bank = Bank::create([
                            'name'=>$bank['Bank Name'],
                            'state_id'=>$bank_state->id,
                            'phone_number'=>$bank['Phone Number'],
                            'website'=>$bank['Website'],
                            'msa_code'=>$bank_city->id,
                            'city_id'=>$bank_city->id,
                            'cp_name'=>$bank['Contact Person Name'],
                            'cp_email'=>$bank['Contact Person Email'],
                            'cp_phone'=>$bank['Contact Person Phone'],
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
            if($this->not_inserted_banks!=[])
            {
                $this->addError('upload_error','These Banks are not inserted');
            }
            else
            {
                $this->addError('upload_success','All Banks inserted successfully');
            }
            $this->file = null;
        }
        else{
            $this->addError('file_error','Please select the file again');
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
}
