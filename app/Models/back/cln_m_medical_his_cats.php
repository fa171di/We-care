<?php

namespace App\Models\back;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cln_m_medical_his_cats extends Model
{
    use HasFactory;
    protected $fillable = ['name_ar','name_en','s_date',
        'e_date','num','note','active','year','ord',
        'act','alert'];
    protected $table = 'cln_m_medical_his_cats';
}
