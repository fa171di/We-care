<?php

namespace App\Models\back;

use Illuminate\Database\Eloquent\Relations\Pivot;

class cln_x_prev_icd10_pivot extends Pivot
{

    public function gnr_m_patients()
    {
        return $this->belongsTo(gnr_m_patients::class, 'patient')->withDefault();
    }

    public function doctors()
    {
        return $this->belongsTo(doctors::class, 'doc')->withDefault();
    }


}
