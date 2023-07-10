<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerBank extends Model
{
    use HasFactory;
    protected $table = 'customer_bank';

    protected $fillable = [
        'bank_name',
        'bank_email',
        'bank_phone_numebr',
        'website',
        'msa_code',
        'state',
        'display_reports',
        'city_id'
    ];

    public function contract(){
       return $this->belongsTo(Contract::class,'id','bank_id');
    }

    public function user(){
       return $this->belongsTo(User::class,'id','bank_id');
    }
}
