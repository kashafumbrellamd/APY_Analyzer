<?php

namespace App\Http\Livewire;

use Livewire\WithFileUploads;
use Livewire\Component;
use App\Models\CustomerBank;
use App\Models\Contract;
use Str;
use App\Models\Zip_code;
use App\Models\Cities;
use App\Models\State;
use App\Models\Payment as Pay;
use App\Http\Controllers\PaymentController;
use Auth;
use DB;

class Payment extends Component
{
    use WithFileUploads;

    public $type = '';
    public $bank = '';
    public $amount = '';

    public $first_name = '';
    public $last_name = '';
    public $email = '';
    public $phone_number = '';
    public $card_number = '';
    public $cvc = '';
    public $exp_month = '';
    public $exp_year = '';
    public $zip_code = '';
    public $state = '';
    public $city = '';
    public $address = '';


    public function mount($id,$type)
    {
        $this->type = $type;
        $this->bank = CustomerBank::findOrFail($id);
        $this->amount = Contract::where('bank_id',$id)->where('contract_type',$type)->orderBy('id','desc')->first()->charges;
    }

    public function render()
    {
        return view('livewire.payment');
    }

    public function submitForm(){
        // $name = $this->first_name . $this->last_name;
        // $zc = DB::table('tbl_zip_codes_cities')->where('zip_code',$this->zip_code)->first();
        // $city = $zc->city;
        // $state = $zc->state;
        // $input_order = [
        //     'user' => [
        //         'description' => $this->first_name . " " . $this->last_name,
        //         'email' => $this->email,
        //         'firstname' => $this->first_name,
        //         'lastname' => $this->last_name,
        //         'phoneNumber' => $this->phone_number,
        //     ],
        //     'info' => [
        //         'subject' => '',
        //         'user_id' => $this->bank->id,
        //         'amount' => $this->amount,
        //     ],
        //     'billing_info' => [
        //         'amount' => $this->amount,
        //         'credit_card' => [
        //             'number' => $this->card_number,
        //             'expiration_month' => $this->exp_month,
        //             'expiration_year' => $this->exp_year,
        //         ],
        //         // 'integrator_id' => $this->subject . '-' . $this->session_id,
        //         'csc' => $this->cvc,
        //         'billing_address' => [
        //             'name' => $name,
        //             'street_address' => $this->address,
        //             'city' => $city,
        //             'state' => $state,
        //             'zip' => $this->zip_code,
        //         ]
        //     ]
        // ];

        // $pay = new PaymentController();
        // $response = ($pay->new_createCustomerProfile($input_order));
        // if($response['messages']['message'][0]['text'] == "Successful."){
        $contract = Contract::where('bank_id',$this->bank->id)->orderby('id','desc')->first();
        if($contract != null){
            if($contract->contract_start == "0000-00-00"){
                $pay = Pay::create([
                    'bank_id' => $this->bank->id,
                    'cheque_number' => null,
                    'cheque_image' => null,
                    'amount' => $this->amount,
                    'bank_name' => $this->bank->bank_name,
                    'status' => "0",
                    'payment_type' => $this->type,
                ]);
            }else{
                if(date('Y-m-d') > $contract->contract_end){
                    $contract = Contract::create([
                        'contract_start' => date('Y-m-d'),
                        'contract_end' => date('Y-m-d', strtotime(date('Y-m-d'). ' + 1 year')),
                        'charges' => $this->amount,
                        'bank_id' => $this->bank->id,
                    ]);
                }
                $pay = Pay::create([
                    'bank_id' => $this->bank->id,
                    'cheque_number' => null,
                    'cheque_image' => null,
                    'amount' => $this->amount,
                    'bank_name' => $this->bank->bank_name,
                    'status' => "0",
                    'payment_type' => $this->type,
                ]);
            }
        }else{
            $this->addError("error",$response['messages']['message'][0]['text']);
        }

        // if(date('Y-m-d') > $contract->contract_end){
        //     $contract = Contract::create([
        //         'contract_start' => date('Y-m-d'),
        //         'contract_end' => date('Y-m-d', strtotime(date('Y-m-d'). ' + 1 year')),
        //         'charges' => $this->amount,
        //         'bank_id' => $this->bank->id,
        //     ]);
        // }
        // $pay = Pay::create([
        //     'bank_id' => $this->bank->id,
        //     'cheque_number' => null,
        //     'cheque_image' => null,
        //     'amount' => $this->amount,
        //     'bank_name' => $this->bank->bank_name,
        //     'status' => "0",
        //     'payment_type' => $this->type,
        // ]);

        if(!Auth::check()){
            return redirect(url('/signin'));
        }else{
            return redirect(url('/home'));
        }
    }

    public function fetch_zip_code(){
        if (Str::length($this->zip_code) >= 5) {
            $zip = Zip_code::where('zip_code',$this->zip_code)->first();
                $this->city = $zip->city;
                $this->state = $zip->state;
            // if ($zip != null) {
            //     $this->city = Cities::where('name',$zip->city)->pluck('id')->first();
            //     $this->state = State::where('name',$zip->state)->pluck('id')->first();
            // }
        }else{
            $this->state = "";
            $this->city = "";
        }
    }
}
