<?php

namespace App\Models\back;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cln_m_icd10_cat extends Model
{
    use HasFactory;
    protected $fillable = ['name_ar','name_en','act', 'created_at', 'updated_at'];
    protected $table = 'cln_m_icd10_cat';
}
