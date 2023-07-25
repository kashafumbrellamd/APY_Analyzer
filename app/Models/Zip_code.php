<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zip_code extends Model
{
    use HasFactory;
    protected $table = 'tbl_zip_codes_cities';

    protected $fillable = [
        'zip_code',
        'city',
        'state',
        'abbreviation',
        'status',

    ];
}
