<?php

namespace App\Models\back;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cln_x_prev_dia extends Model
{
    use HasFactory;
    protected $fillable = ['visit', 'patient', 'doc','val','date'];
    protected $table = 'cln_x_prev_dia';

    public function cln_x_visits()
    {
        return $this->belongsTo(cln_x_visits::class, 'visit','id');
    }

    public function gnr_m_patients()
    {
        return $this->belongsTo(gnr_m_patients::class, 'patient','id');
    }

    public function doctors()
    {
        return $this->belongsTo(doctors::class, 'doc','id');
    }

    public function date()
    {
        return $time =Carbon::parse($this->attributes['date'])->format('Y-m-d الساعة: h:i A');
    }
}
