<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use App\Models\User;
use App\Models\BankPrices;
use App\Models\RateType;
use App\Models\Packages;
use App\Models\OTP;

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

    public function otp_apply($id)
    {
        return view('apply_otp',['id'=>$id]);
    }


    public function bank_login(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user == null) {
            return redirect()->back();
        }
        $code = rand(111111, 999999);
        $otp = OTP::updateOrCreate(
            ['user_id' => $user->id],
            ['opt' => $code, 'expiry_date' => now()->addSeconds(120)]
        );
        Mail::to($user->email)->send(new OtpMail($otp));
        return redirect()->route('otp_apply',['id'=>$user->id]);
    }

    public function verify_login(Request $request)
    {
        $user = User::find($request->id);
        if(isset($user)){
            $otp = OTP::where('user_id',$request->id)->first();
            if($otp->opt == $request->otp){
                Auth::login($user, $remember = true);
                return redirect()->route('home');
            }else{
                return redirect()->back();
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

        $data = BankPrices::get_min_max_func();
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

        $data = BankPrices::get_min_max_func();
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

}
