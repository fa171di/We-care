<?php

namespace App\Models\back;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cln_m_medical_his extends Model
{
    use HasFactory;
    protected $fillable = ['cat','name_ar','name_en','s_date',
        'e_date','num','note','active',
        'act','alert'];
    protected $table = 'cln_m_medical_his';
}
