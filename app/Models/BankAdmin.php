<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAdmin extends Model
{
    use HasFactory;
    protected $table = 'bank_admin';

    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'bank_id',
        'designation',
        'employee_id',
        'gender',
    ];

    public function customer_bank(){
        return $this->belongsTo(CustomerBank::class,'bank_id','id');
    }
}
