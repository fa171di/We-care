<?php

namespace App\Models\back;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class gnr_m_cities extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    protected $table = 'gnr_m_cities';

    public function gnr_m_areas()
    {
        return $this->hasMany(gnr_m_areas::class,'city','id');
    }

    public function gnr_m_patients()
    {
        return $this->hasMany(gnr_m_patients::class,'p_city','id');
    }
}
