<?php

namespace App\Models\back;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class gnr_m_nationality extends Model
{
    use HasFactory;
    protected $fillable = ['name_ar', 'name_en'];
    protected $table = 'gnr_m_nationality';

    public function gnr_m_patients()
    {
        return $this->hasMany(gnr_m_patients::class,'nationality','id');
    }
}
