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

    public function gnr_m_patients()
    {
        return $this->belongsToMany(gnr_m_patients::class, 'cln_x_medical_his','med_id','patient')
            ->withPivot('cat','s_date','e_date','note','date');
    }
}
