<?php

namespace App\Models\back;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cln_x_visits_services extends Pivot
{
    use HasFactory;
    protected $fillable = ['visit_id ', 'clinic', 'service','status'
        ,'patient ',
        'd_start ','srv_type'];
    protected $table = 'cln_x_visits_services';

    public function gnr_m_clinics()
    {
        return $this->belongsTo(gnr_m_clinics::class, 'clinic','id');
    }
    public function gnr_m_patients()
    {
        return $this->belongsTo(gnr_m_patients::class, 'patient','id');
    }


}
