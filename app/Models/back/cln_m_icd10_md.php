<?php

namespace App\Models\back;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class cln_m_icd10_md extends Model
{
    use HasFactory;

    protected $fillable = ['name_ar', 'name_en', 'act'];
    protected $table = 'cln_m_icd10_md';

    public function doctor(){
        return $this->hasMany(doctors::class, 'cln_m_icd10_md_id','id');
    }
    public function scopeSelection($query)
    {
        return $query->select('name_ar', 'name_en', 'act');
    }

    public function getAct()
    {
        return $this->act == '1' ? 'مفعل' : 'غير مفعل';

    }

}
