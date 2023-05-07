<?php

namespace App\Models\back;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class gnr_m_clinics extends Model
{
    use HasFactory;
    protected $fillable = ['name_ar', 'name_en','act','type','linked'];
    protected $table = 'gnr_m_clinics';

    public function doctor(){
        return $this->hasMany(doctors::class, 'subgrp','id');
    }

    public function cln_x_visits_services(){
        return $this->hasMany(cln_x_visits_services::class, 'clinic','id');
    }

    public function cln_x_visits(){
        return $this->hasMany(cln_x_visits::class, 'clinic','id');
    }
    public function getAct()
    {
        return $this->act == '1' ? 'مفعل' : 'غير مفعل';

    }
}
