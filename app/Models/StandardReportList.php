<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StandardReportList extends Model
{
    use HasFactory;

    protected $table = 'standard_report_list';

    protected $fillable = [
        'name','status','city_id'
    ];

    public function cities(){
        return $this->hasOne(Cities::class,'id','city_id');
    }

    public function cbsa(){
        return $this->hasOne(Bank::class,'cbsa_code','city_id');
    }
}
