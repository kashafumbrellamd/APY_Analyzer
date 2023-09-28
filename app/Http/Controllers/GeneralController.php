<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use App\Models\User;
use App\Models\BankPrices;
use App\Models\CustomerBank;
use App\Models\RateType;
use App\Models\Packages;
use App\Models\Payment;
use App\Models\Contract;
use App\Models\OTP;
use App\Models\BankRequest;


class GeneralController extends Controller
{
    public function manage_banks()
    {
        return view('manage_banks.index');
    }

    public function add_bank_rates()
    {
        return view('manage_banks.add_rates');
    }

    public function manage_rate_types()
    {
        return view('manage_rate_types.index');
    }

    public function add_customer_bank()
    {
        return view('customer_bank.index');
    }

    public function customer_bank_admin()
    {
        return view('customer_bank.admin');
    }

    public function customer_bank_user()
    {
        return view('customer_bank.user');
    }

    public function view_bank_reports()
    {
        return view('customer_bank.view_bank_reports');
    }

    public function view_detailed_reports()
    {
        return view('customer_bank.view_detailed_reports');
    }

    public function view_speical_reports()
    {
        return view('customer_bank.view_speical_reports');
    }

    public function bank_type()
    {
        return view('customer_bank.bank_type');
    }

    public function otp_apply($id)
    {
        return view('apply_otp',['id'=>$id]);
    }

    public function manage_stories()
    {
        return view('stories');
    }

    public function manage_packages()
    {
        return view('packages');
    }

    public function summary_reports()
    {
        return view('customer_bank.summary_reports');
    }

    public function bank_request()
    {
        return view('customer_bank.bank_request');
    }

    public function view_registered_bank()
    {
        return view('customer_bank.view_registered_bank');
    }

    public function view_detailed_customer_bank($id)
    {
        return view('customer_bank.view_detailed_customer_bank',compact('id'));
    }

    public function customize_packages()
    {
        return view('customer_bank.customize_packages');
    }

    public function view_customization_requests()
    {
        return view('customer_bank.view_customization_requests');
    }


    public function bank_login(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user == null) {
            return redirect()->back();
        }

        $contract = Contract::where('bank_id',$user->bank_id)->orderby('id','desc')->first();
        if($contract != null){
            if($contract->contract_end >= date('Y-m-d')){
                $payment = Payment::where('bank_id',$user->bank_id)->where('payment_type','complete')->orderby('id','desc')->first();
                if($payment->status == "1"){
                    $code = rand(111111, 999999);
                    $otp = OTP::updateOrCreate(
                        ['user_id' => $user->id],
                        ['opt' => $code, 'expiry_date' => now()->addSeconds(120)]
                    );
                    Mail::to($user->email)->send(new OtpMail($otp));
                    return redirect()->route('otp_apply',['id'=>$user->id]);
                }else{
                    return redirect()->back()->with('approval','Please wait for the Admin Approval to Proceed');
                }
            }else{
                return redirect()->route('payment',['id'=>$user->bank_id, 'type'=>'complete'])->with('contract','Sorry, Your Contract has Expired. Please fill the Form below to make payment.');
            }
        }else{
            return redirect()->route('customer_package',['id'=>$user->bank_id]);
        }
    }

    public function verify_login(Request $request)
    {
        $user = User::find($request->id);
        $payment = Payment::where('bank_id',$user->bank_id)->first();
        if(isset($user)){
            if($payment->status == "1"){
                $otp = OTP::where('user_id',$request->id)->first();
                if($otp->opt == $request->otp){
                    Auth::login($user, $remember = true);
                    return redirect()->route('home');
                }else{
                    return redirect()->back();
                }
            }else{
                return redirect()->back()->with('success','Please wait for the Admin Approval to Proceed');
            }
        }else{
            return redirect()->back();
        }
    }

    public function mhlChart(){
        $rate_cd = RateType::where('name','like','%CD%')->select('id')->get()->toArray();
        $ids = [];
        $max = [];
        $min = [];
        $ids = array_column($rate_cd, 'id');
        $customer_type = CustomerBank::where('id',auth()->user()->bank_id)->first();
        if($customer_type->display_reports=='state'){
            $data = BankPrices::get_min_max_func('state',$customer_type->state,"");
        }elseif ($customer_type->display_reports == 'msa') {
            $data = BankPrices::get_min_max_func('msa',$customer_type->msa,"");
        }else {
            $data = BankPrices::get_min_max_func('all','0',"","");
        }
        foreach ($data as $key => $value) {
            if(in_array($value->id,$ids)){
                array_push($max,$value->c_max);
                array_push($min,$value->c_min);
            }
        }
        return response()->json(['max'=>$max,'min'=>$min]);
    }

    public function mamChart(){
        $rate_cd = RateType::where('name','like','%CD%')->select('id')->get()->toArray();
        $ids = [];
        $med = [];
        $avg = [];
        $ids = array_column($rate_cd, 'id');

        $customer_type = CustomerBank::where('id',auth()->user()->bank_id)->first();
        if($customer_type->display_reports=='state'){
            $data = BankPrices::get_min_max_func('state',$customer_type->state,"");
        }elseif ($customer_type->display_reports == 'msa') {
            $data = BankPrices::get_min_max_func('msa',$customer_type->msa,"");
        }else {
            $data = BankPrices::get_min_max_func('all','0',"","");
        }

        foreach ($data as $key => $value) {
            if(in_array($value->id,$ids)){
                array_push($med,$value->c_med);
                array_push($avg,$value->c_avg);
            }
        }
        return response()->json(['med'=>$med,'avg'=>$avg]);
    }

    public function getLabels(){
        $rate_cd = RateType::where('name','like','%CD%')->select('name')->get()->toArray();
        $ids = [];
        $med = [];
        $avg = [];
        $ids = array_column($rate_cd, 'name');
        return response()->json($ids);
    }

    public function add_packages(){
        // Platinum Package (All Bank details)
        Packages::create([
            'name' => 'Platinum Package',
            'price' => 99.99,
            'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
            'duration' => 1,
            'package_type' => 'custom',
        ]);

        // Gold Package (Banks of your State)
        Packages::create([
            'name' => 'Gold Package',
            'price' => 79.99,
            'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
            'duration' => 1,
            'package_type' => 'state',
        ]);

        // Silver Package (Only your MSA code Banks)
        Packages::create([
            'name' => 'Silver Package',
            'price' => 49.99,
            'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
            'duration' => 1,
            'package_type' => 'msa',
        ]);
    }

    public function manage_charity()
    {
        return view('charity.index');
    }

    public function seperate_reports()
    {
        return view('customer_bank.view_seperate_report');
    }

    public function bank_request_submit(Request $request){
        if(Auth::check()){
           $id = auth()->user()->id;
        }else{
            $id = null;
        }

        BankRequest::create([
            'name' => $request->name,
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            'zip_code' => $request->zip_code,
            'description' => $request->description,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'user_id' => $id,
        ]);

        return redirect()->back()->with('success','Bank Request Made Successfully.');
    }

    public function update_price($id){
        if(Auth::check()){
            $rt = RateType::orderby('id','ASC')->get();
            $prices = [];
            foreach ($rt as $key => $rate) {
                $data = BankPrices::select('bank_prices.*', 'banks.name as bank_name','rate_types.name')
                ->join('banks', 'bank_prices.bank_id', 'banks.id')
                ->join('rate_types', 'rate_types.id', 'bank_prices.rate_type_id')
                ->whereIn('bank_prices.created_at', function ($query) use ($id,$rate) {
                    $query->selectRaw('MAX(created_at)')
                        ->from('bank_prices')
                        ->where('rate_type_id', $rate->id)
                        ->where('is_checked', 1)
                        ->where('bank_id', $id)
                        ->groupBy('bank_id');
                })
                ->where('rate_type_id', $rate->id)
                ->where('is_checked', 1)
                ->where('bank_id', $id) // Assuming $banks is an array containing selected bank IDs
                ->groupBy('bank_id') // Group by bank_id to get the latest rate for each bank in the current rate type
                ->orderBy('current_rate', 'DESC')
                ->first();
                array_push($prices,$data);
            }
            return view('update_price',compact('id','prices'));
        }else{
            return redirect(url('/signin'));
        }
    }

    public function post_update_price(Request $request){
            foreach ($request->rate_type_id as $key => $value) {
                $check = BankPrices::where('bank_id',$request->bank_id)->where('rate_type_id',$value)->where('is_checked','1')->orderBy('id','desc')->first();
                if($check != null){
                    if($check->current_rate != $request->current_rate[$key]){
                        BankPrices::create([
                            'bank_id' => $request->bank_id,
                            'rate_type_id' => $value,
                            'rate' => $check->rate,
                            'previous_rate' => $check->current_rate,
                            'current_rate' => $request->current_rate[$key],
                            'change' => $check->rate-$request->current_rate[$key],
                        ]);
                    }
                }
            }
            return redirect(url('/'));
    }
}
