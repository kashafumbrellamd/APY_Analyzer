<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\CustomerBank;
use App\Models\Payment;
use DB;
use Illuminate\Http\Request;

class UserPackageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth()->check() && Auth()->user()->hasRole('bank-admin')){
            $bank = CustomerBank::find(Auth()->user()->bank_id);
            if($bank->display_reports == 'custom'){
                $custom_package_banks = DB::table('custom_package_banks')->where('bank_id',$bank->id)->first();
                if($custom_package_banks != null){
                    $payment = Payment::where('bank_id',$bank->id)->where('status','1')->where('payment_type','complete')->first();
                    if($payment != null){
                        return $next($request);
                    }else{
                        return redirect(url('payment/'.$bank->id));
                    }
                }else{
                    return redirect(url('customerPackage/'.$bank->id));
                }
            }
        }
        return $next($request);
    }
}
