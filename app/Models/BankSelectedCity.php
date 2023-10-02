<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankSelectedCity extends Model
{
    use HasFactory;
    protected $table = 'bank_selected_city';
    protected $fillable = [
        'bank_id',
        'city_id',
    ];
}
