<?php

namespace App\Models\back;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cln_m_icd10 extends Model
{
    use HasFactory;
    protected $fillable = ['code', 'name_ar','name_en','cat',
        'docs','created_at', 'updated_at'];
    protected $table = 'cln_m_icd10';
}
