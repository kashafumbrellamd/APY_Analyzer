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
    ];

    public function BanksWithState()
    {
        $states = Bank::join('states', 'banks.state_id', '=', 'states.id')
             ->select('banks.*', 'states.name as state_name')
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
}
