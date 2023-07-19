<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecializationRates extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank_id',
        'rate',
        'description',
    ];

    public static function specialPricesWithBankId($id){
        $sprates = SpecializationRates::where('bank_id',$id)->get();
        return $sprates;
    }

    public function bank(){
        return $this->belongsTo(Bank::class,'bank_id','id');
    }
}
