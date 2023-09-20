<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank_id',
        'cheque_number',
        'cheque_image',
        'amount',
        'bank_name',
        'status',
        'payment_type',
    ];
}
