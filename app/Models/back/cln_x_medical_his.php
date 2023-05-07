<?php

namespace App\Models\back;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cln_x_medical_his extends Model
{
    use HasFactory;
    protected $fillable = ['cat','med_id','s_date','e_date',
        'num','active','note','date',
        'patient','doc','alert','year'];
    protected $table = 'cln_x_medical_his';
}
