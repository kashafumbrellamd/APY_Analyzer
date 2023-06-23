<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use App\Models\User;
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

    public function otp_apply()
    {
        return view('apply_otp');
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
        return redirect()->route('otp_apply');
    }

    public function verify_login(Request $request)
    {
        $user = User::find(22);
        if(isset($user)){
            Auth::login($user, $remember = true);
            return redirect()->route('home');
        }else{
            dd('not Login');
        }
    }

}
