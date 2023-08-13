<?php

namespace App\Models\back;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cln_x_visits extends Model
{
    use HasFactory;
    protected $fillable = ['patient ', 'clinic', 'type','d_start ','note','price'];
    protected $table = 'cln_x_visits';


    public function patient()
    {
        return $this->belongsTo(gnr_m_patients::class, 'patient','id')->withDefault();
    }

    public function gnr_m_clinics()
    {
        return $this->belongsTo(gnr_m_clinics::class, 'clinic','id')->withDefault();
    }

    public function cln_m_services()
    {
        return $this->belongsToMany(cln_m_services::class, 'cln_x_visits_services','visit_id','service');
    }

    public function cln_m_icd10()
    {
        return $this->belongsToMany(cln_m_icd10::class, 'cln_x_prev_icd10',
            'visit','opr_id')
            ->withPivot('patient','doc','date')
            ->using(cln_x_prev_icd10_pivot::class);
    }

    public function cln_x_prev_com(){
        return $this->hasMany(cln_x_prev_com::class, 'visit','id');
    }

    public function cln_x_prev_str(){
        return $this->hasMany(cln_x_prev_str::class, 'visit','id');
    }

    public function cln_x_prev_cln(){
        return $this->hasMany(cln_x_prev_cln::class, 'visit','id');
    }

    public function cln_x_prev_not(){
        return $this->hasMany(cln_x_prev_not::class, 'visit','id');
    }

    public function cln_x_prev_dia(){
        return $this->hasMany(cln_x_prev_dia::class, 'visit','id');
    }


    public function getsType()
    {
        return $this->type == '1' ? 'منتهية' : 'غير منتهية';

    }

    public function d_start()
    {
        return $time =Carbon::parse($this->attributes['d_start'])->format('Y-m-d الساعة: h:i A');
    }

}
