<?php

namespace App\Models\back;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class gnr_m_areas extends Model
{
    use HasFactory;
    protected $fillable = ['city', 'name'];
    protected $table = 'gnr_m_areas';

    public function gnr_m_cities():BelongsTo
    {
        return $this->belongsTo(gnr_m_cities::class,'city','id');
    }

    public function gnr_m_patients()
    {
        return $this->hasMany(gnr_m_patients::class,'p_area','id');
    }

}
