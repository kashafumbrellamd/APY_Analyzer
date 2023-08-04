<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'zip_code',
        'state_id',
        'city_id',
        'description',
        'user_id',
        'email',
        'phone_number',
    ];

    public function state(){
        return $this->belongsTo(State::class);
    }

    public function cities(){
        return $this->belongsTo(Cities::class,'city_id','id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
