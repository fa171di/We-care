<?php

namespace App\Models\back;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cln_m_services extends Model
{
    use HasFactory;
    protected $fillable = ['clinic', 'name_ar','name_en'];
    protected $table = 'cln_m_services';

    public function gnr_m_clinics()
    {
        return $this->belongsTo(gnr_m_clinics::class, 'clinic','id');
    }

    public function cln_x_visits()
    {
        return $this->belongsToMany(cln_x_visits::class, 'cln_x_visits_services','service','visit_id');
    }
}
