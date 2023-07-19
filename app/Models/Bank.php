<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'state_id',
        'phone_number',
        'website',
        'msa_code',
        'city_id',
        'bank_type_id',
        'cp_name',
        'cp_email',
        'cp_phone',
    ];

    public static function BanksWithState()
    {
        $states = Bank::join('states', 'banks.state_id', '=', 'states.id')
             ->select('banks.*', 'states.name as state_name')
             ->get();
        return $states;
    }

    public static function BanksWithStateAndType()
    {
        $states = Bank::join('states', 'banks.state_id', '=', 'states.id')
             ->join('bank_types', 'bank_types.id', '=', 'banks.bank_type_id')
             ->select('banks.*', 'states.name as state_name','bank_types.name as type_name')
             ->with('cities')
             ->get();
        return $states;
    }

    public function BankWithState($id)
    {
        $states = Bank::where('banks.id',$id)
            ->join('states', 'banks.state_id', '=', 'states.id')
            ->select('banks.*', 'states.name as state_name')
            ->get();
        return $states;
    }

    public function cities(){
        return $this->belongsTo(Cities::class,'city_id','id');
    }
}
