<?php

namespace App\Models\back;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cln_m_icd10 extends Model
{
    use HasFactory;
    protected $fillable = ['code', 'name_ar','name_en','cat','created_at', 'updated_at'];
    protected $table = 'cln_m_icd10';

    public function cln_x_visits()
    {
        return $this->belongsToMany(cln_x_visits::class, 'cln_x_prev_icd10',
            'opr_id','visit') ->withPivot('patient','doc','date')
            ->using(cln_x_prev_icd10_pivot::class);;
    }
}
