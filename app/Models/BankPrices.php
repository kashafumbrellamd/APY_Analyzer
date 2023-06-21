<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankPrices extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank_id',
        'rate_type_id',
        'rate',
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
        $latestRates= BankPrices::select('bank_prices.id', 'bank_prices.rate_type_id', 'bank_prices.rate', 'bank_prices.created_at','rate_types.name as rate_type_name')
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
}
