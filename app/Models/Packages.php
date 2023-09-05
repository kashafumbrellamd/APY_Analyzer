<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Packages extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'price',
        'description',
        'duration',
        'package_type',
        'additional_price',
        'number_of_units',
    ];
}
