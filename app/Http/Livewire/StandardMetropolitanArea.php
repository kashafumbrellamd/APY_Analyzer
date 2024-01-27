<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Cities;
use App\Models\Bank;
use App\Models\StandardReportList;
use Livewire\WithPagination;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Response;

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

    public function downloadBanks($id){
        $cbsa_code = StandardReportList::find($id)->city_id;
        $banks = Bank::join('bank_prices','bank_prices.bank_id','banks.id')
            ->where('banks.cbsa_code',$cbsa_code)
            ->orderBy('banks.name')
            ->groupBy('banks.name')
            ->select('banks.name')
            ->get();

        $spreadsheet = new Spreadsheet();
        $activeWorksheet = $spreadsheet->getActiveSheet();
        $activeWorksheet->setCellValue('A1', 'Name');
        $number = 2;
        foreach ($banks as $key => $bank) {
            $activeWorksheet->setCellValue('A'.$number, $bank->name);
            $number++;
        }
        $writer = new Xlsx($spreadsheet);

        $headers = [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="Added_Rates_Banks.xlsx"',
        ];

        $callback = function () use ($writer) {
            $writer->save('php://output');
        };

        return Response::stream($callback, 200, $headers);
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
