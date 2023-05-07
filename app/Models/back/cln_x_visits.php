<?php

namespace App\Models\back;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cln_x_visits extends Model
{
    use HasFactory;
    protected $fillable = ['patient ', 'clinic', 'type','d_start ','note'];
    protected $table = 'cln_x_visits';


    public function gnr_m_clinics()
    {
        return $this->belongsTo(gnr_m_clinics::class, 'clinic','id');
    }

    public function cln_m_services()
    {
        return $this->belongsToMany(cln_m_services::class, 'cln_x_visits_services','visit_id','service');
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
