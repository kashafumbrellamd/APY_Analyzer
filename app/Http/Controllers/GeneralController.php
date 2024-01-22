<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use App\Models\User;
use App\Models\BankPrices;
use App\Models\CustomerBank;
use App\Models\Bank;
use App\Models\RateType;
use App\Models\Packages;
use App\Models\Payment;
use App\Models\Contract;
use App\Models\OTP;
use App\Models\BankRequest;
use Illuminate\Support\Facades\Cache;


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

    public function standard_metropolitan_area()
    {
        return view('standard_metropolitan_area');
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
            return redirect()->back()->with('error','Sorry This Email is not Registered.');
        }

        $contract = Contract::where('bank_id',$user->bank_id)->orderby('id','desc')->first();
        if($contract != null){
            if($contract->contract_start != "0000-00-00"){
                if(date('Y-m-d', strtotime($contract->contract_start . ' + 4 weeks ')) > date('Y-m-d')){
                    $code = rand(111111, 999999);
                    $otp = OTP::updateOrCreate(
                        ['user_id' => $user->id],
                        ['opt' => $code, 'expiry_date' => now()->addSeconds(120)]
                    );
                    Mail::to($user->email)->send(new OtpMail($otp));
                    return redirect()->route('otp_apply',['id'=>$user->id]);
                }
                if($contract->contract_end >= date('Y-m-d')){
                    $payment = Payment::where('bank_id',$user->bank_id)->where('payment_type','complete')->orderby('id','desc')->first();
                    if($payment != null){
                        if($payment->status == "1"){
                            $code = rand(111111, 999999);
                            $otp = OTP::updateOrCreate(
                                ['user_id' => $user->id],
                                ['opt' => $code, 'expiry_date' => now()->addSeconds(120)]
                            );
                            Mail::to($user->email)->send(new OtpMail($otp));
                            return redirect()->route('otp_apply',['id'=>$user->id]);
                        }else{
                            return redirect()->back()->with('approval','Please wait for Administration approval to proceed.');
                        }
                    }else{
                        return redirect()->route('payment',['id'=>$user->bank_id, 'type'=>'complete'])->with('contract','Four-Week Free Trial has ended.  Please make the payment and wait for Admin approval.  Thank you.');
                    }
                }else{
                    return redirect()->route('payment',['id'=>$user->bank_id, 'type'=>'complete'])->with('contract','Sorry, Your Contract has Expired. Please fill the Form below to make payment.');
                }
            }else{
                $payment = Payment::where('bank_id',$user->bank_id)->where('payment_type','complete')->orderby('id','desc')->first();
                if($payment != null){
                    if($payment->status == "1"){
                        $code = rand(111111, 999999);
                        $otp = OTP::updateOrCreate(
                            ['user_id' => $user->id],
                            ['opt' => $code, 'expiry_date' => now()->addSeconds(120)]
                        );
                        Mail::to($user->email)->send(new OtpMail($otp));
                        return redirect()->route('otp_apply',['id'=>$user->id]);
                    }else{
                        return redirect()->back()->with('approval','Please wait for Administration approval to proceed.');
                    }
                }else{
                    return redirect()->route('payment',['id'=>$user->bank_id, 'type'=>'complete'])->with('contract','Please fill the Form below to make payment.');
                }
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
            // if($payment->status == "1"){
                $otp = OTP::where('user_id',$request->id)->first();
                if($otp->opt == $request->otp){
                    Auth::login($user, $remember = true);
                    return redirect()->route('home');
                }else{
                    return redirect()->back();
                }
            // }else{
                // return redirect()->back()->with('success','Please wait for Administration approval to proceed.');
            // }
        }else{
            return redirect()->back();
        }
    }

    public function mhlChart(){
        if(Auth::user()->user_type != "admin"){
            if(!Cache::has('MHLChart')){
                $rate_cd = RateType::where('name','like','%CD%')->select('id')->orderby('display_order')->get()->toArray();
                $ids = [];
                $max = [];
                $min = [];
                $my = [];
                $ids = array_column($rate_cd, 'id');
                $customer_type = CustomerBank::where('id',auth()->user()->bank_id)->first();
                $my_bank_id = Bank::where('banks.name','like',$customer_type->bank_name)->pluck('id')->first();
                $my_data = BankPrices::BankPricesWithType($my_bank_id);
                if(count($my_data) != 0){
                    foreach($my_data as $md){
                        if(in_array($md->rate_type_id,$ids)){
                            array_push($my,$md->current_rate);
                        }
                    }
                }
                if($customer_type->display_reports=='state'){
                    $data = BankPrices::get_min_max_func('state',$customer_type->state,"","");
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
                Cache::put('MHLChart', ['max'=>$max,'min'=>$min,'my'=>$my], now()->addMinutes(30));
            }else{
                $data = Cache::get('MHLChart');
                $max = $data['max'];
                $min = $data['min'];
                $my = $data['my'];
            }
            return response()->json(['max'=>$max,'min'=>$min,'my'=>$my]);
        }
    }

    public function mamChart(){
        if(Auth::user()->user_type != "admin"){
            if(!Cache::has('MAMChart')){
                $rate_cd = RateType::where('name','like','%CD%')->orderby('display_order')->select('id')->get()->toArray();
                $ids = [];
                $med = [];
                $avg = [];
                $my = [];
                $ids = array_column($rate_cd, 'id');
                $customer_type = CustomerBank::where('id',auth()->user()->bank_id)->first();
                $my_bank_id = Bank::where('banks.name','like',$customer_type->bank_name)->pluck('id')->first();
                $my_data = BankPrices::BankPricesWithType($my_bank_id);
                if(count($my_data) != 0){
                    foreach($my_data as $md){
                        if(in_array($md->rate_type_id,$ids)){
                            array_push($my,$md->current_rate);
                        }
                    }
                }
                if($customer_type->display_reports=='state'){
                    $data = BankPrices::get_min_max_func('state',$customer_type->state,"","");
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
                Cache::put('MAMChart', ['med'=>$med,'avg'=>$avg,'my'=>$my], now()->addMinutes(30));
            }else{
                $data = Cache::get('MAMChart');
                $med = $data['med'];
                $avg = $data['avg'];
                $my = $data['my'];
            }
            return response()->json(['med'=>$med,'avg'=>$avg,'my'=>$my]);
        }
    }

    public function mhlChartNonCD(){
        if(Auth::user()->user_type != "admin"){
            if(!Cache::has('NonCDMHLChart')){
                $rate_cd = RateType::where('name','not like','%CD%')->orderby('display_order')->select('id')->get()->toArray();
                $ids = [];
                $max = [];
                $min = [];
                $my = [];
                $ids = array_column($rate_cd, 'id');
                $customer_type = CustomerBank::where('id',auth()->user()->bank_id)->first();
                $my_bank_id = Bank::where('banks.name','like',$customer_type->bank_name)->pluck('id')->first();
                $my_data = BankPrices::BankPricesWithType($my_bank_id);
                if(count($my_data) != 0){
                    foreach($my_data as $md){
                        if(in_array($md->rate_type_id,$ids)){
                            array_push($my,$md->current_rate);
                        }
                    }
                }
                if($customer_type->display_reports=='state'){
                    $data = BankPrices::get_min_max_func('state',$customer_type->state,"","");
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
                Cache::put('NonCDMHLChart', ['max'=>$max,'min'=>$min,'my'=>$my], now()->addMinutes(30));
            }else{
                $data = Cache::get('NonCDMHLChart');
                $max = $data['max'];
                $min = $data['min'];
                $my = $data['my'];
            }
            return response()->json(['max'=>$max,'min'=>$min,'my'=>$my]);
        }
    }

    public function mamChartNonCD(){
        if(Auth::user()->user_type != "admin"){
            if(!Cache::has('NonCDMAMChart')){
                $rate_cd = RateType::where('name','not like','%CD%')->orderby('display_order')->select('id')->get()->toArray();
                $ids = [];
                $med = [];
                $avg = [];
                $my = [];
                $ids = array_column($rate_cd, 'id');
                $customer_type = CustomerBank::where('id',auth()->user()->bank_id)->first();
                $my_bank_id = Bank::where('banks.name','like',$customer_type->bank_name)->pluck('id')->first();
                $my_data = BankPrices::BankPricesWithType($my_bank_id);
                if(count($my_data) != 0){
                    foreach($my_data as $md){
                        if(in_array($md->rate_type_id,$ids)){
                            array_push($my,$md->current_rate);
                        }
                    }
                }
                if($customer_type->display_reports=='state'){
                    $data = BankPrices::get_min_max_func('state',$customer_type->state,"","");
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
                Cache::put('NonCDMAMChart', ['med'=>$med,'avg'=>$avg,'my'=>$my], now()->addMinutes(30));
            }else{
                $data = Cache::get('NonCDMAMChart');
                $med = $data['med'];
                $avg = $data['avg'];
                $my = $data['my'];
            }
            return response()->json(['med'=>$med,'avg'=>$avg,'my'=>$my]);
        }
    }

    public function getLabels(){
        if(!Cache::has('CDLabels')){
            $rate_cd = RateType::where('name','like','%CD%')->select('name')->orderby('display_order')->get()->toArray();
            $ids = [];
            $ids = array_column($rate_cd, 'name');
            Cache::put('CDLabels', $ids, now()->addMinutes(30));
        }else{
            $ids = Cache::get('CDLabels');
        }
        return response()->json($ids);
    }

    public function getNonCDLabels(){
        if(!Cache::has('NonCDLabels')){
            $rate_cd = RateType::where('name','not like','%CD%')->select('name')->orderby('display_order')->get()->toArray();
            $ids = [];
            $ids = array_column($rate_cd, 'name');
            Cache::put('NonCDLabels', $ids, now()->addMinutes(30));
        }else{
            $ids = Cache::get('NonCDLabels');
        }
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
            $rt = RateType::orderby('display_order')->get();
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

    public function flush_cache(){
        Cache::flush();
        dd('cache cleared');
    }
}
