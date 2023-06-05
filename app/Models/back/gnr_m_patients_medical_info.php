<?php

namespace App\Models\back;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class gnr_m_patients_medical_info extends Model
{
    use HasFactory;
    protected $fillable = ['patient ', 'birth_date', 'sex',
       'height', 'father_height','mother_height'];
    protected $table = 'gnr_m_patients_medical_info';

    public function gnr_m_patients(): BelongsTo
    {
        return $this->belongsTo(gnr_m_patients::class,'patient', 'id')->withDefault();
    }

    public function age()
    {
        return Carbon::parse($this->attributes['birth_date'])->age;
    }

}
