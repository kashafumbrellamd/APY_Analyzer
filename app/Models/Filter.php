<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filter extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id',
        'state_id',
        'city_id',
        'bank_type_id',
        'bank_id',
    ];
}
