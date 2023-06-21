<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerBank extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank_name',
        'bank_email',
        'bank_phone_numebr',
        'website',
        'msa_code',
        'state',
    ];
}
