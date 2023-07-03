<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bank;
use App\Models\CustomerBank;
use App\Models\RateType;

class BankPrices extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank_id',
        'rate_type_id',
        'rate',
        'previous_rate',
        'current_rate',
        'change',
        'is_checked',
    ];
    public function rates(){
        return $this->belongsTo(RateType::class);
    }

    public function BankPricesWithType($id)
    {
        // $latestRates = BankPrices::select('bank_prices.*', 'rate_types.name as rate_type_name')
        // ->join('rate_types', 'rate_types.id', '=', 'bank_prices.rate_type_id')
        // ->where('bank_prices.bank_id',$id)
        // ->groupBy('bank_prices.rate_type_id')
        // ->latest('bank_prices.created_at')
        // ->get();
        // $id=2;
        $latestRates= BankPrices::select('bank_prices.id', 'bank_prices.rate_type_id','bank_prices.previous_rate','bank_prices.current_rate','bank_prices.change', 'bank_prices.rate', 'bank_prices.created_at','bank_prices.is_checked','rate_types.name as rate_type_name')
        ->whereIn('bank_prices.created_at', function ($query) use ($id) {
            $query->selectRaw('MAX(created_at)')
                ->from('bank_prices')
                ->where('bank_id', $id)
                ->groupBy('rate_type_id');
        })
        ->where('bank_prices.bank_id', $id)
        ->join('rate_types', 'bank_prices.rate_type_id', '=', 'rate_types.id')
        ->get();
        //BankPrices::distinct('rate_type_id')->where('bank_id',$id)->with('rates')->get();
        // dd($latestRates);
        return $latestRates;
    }

    public function BankReports()
    {
        $filter = CustomerBank::where('id',auth()->user()->bank_id)->first();
        if($filter->display_reports == 'state'){
            $banks = Bank::where('state_id',$filter->state)->get();
        }elseif ($filter->display_reports == 'msa') {
            $banks = Bank::where('msa_code',$filter->msa_code)->get();
        }else{
            $banks = Bank::all();
        }
        $rate_types = RateType::orderby('name','ASC')->get();
        foreach ($banks as $key => $bank) {
            foreach ($rate_types as $re_key => $rt) {
                $bank[$rt->id] = BankPrices::where('bank_id',$bank->id)
                ->where('rate_type_id',$rt->id)
                ->where('is_checked',1)
                ->orderby('id','DESC')
                ->first();
            }
        }
        return $banks;
    }

    public function BankReportsWithState($state_id)
    {
        $banks = Bank::where('state_id',$state_id)->get();
        $rate_types = RateType::orderby('name','ASC')->get();
        foreach ($banks as $key => $bank) {
            foreach ($rate_types as $re_key => $rt) {
                $bank[$rt->id] = BankPrices::where('bank_id',$bank->id)
                ->where('rate_type_id',$rt->id)
                ->where('is_checked',1)
                ->orderby('id','DESC')
                ->first();
            }
        }
        return $banks;
    }
    public function BankReportsWithMsa($msa)
    {
        $filter = CustomerBank::where('id',auth()->user()->bank_id)->first();
        $banks = Bank::where('state_id',$filter->state)->where('msa_code',$msa)->get();
        $rate_types = RateType::orderby('name','ASC')->get();
        foreach ($banks as $key => $bank) {
            foreach ($rate_types as $re_key => $rt) {
                $bank[$rt->id] = BankPrices::where('bank_id',$bank->id)
                ->where('rate_type_id',$rt->id)
                ->where('is_checked',1)
                ->orderby('id','DESC')
                ->first();
            }
        }
        return $banks;
    }
}
