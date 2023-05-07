<?php

namespace App\Models\back;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cln_m_services extends Model
{
    use HasFactory;
    protected $fillable = ['code', 'clinic', 'name_ar','name_en','ord',
        'act','rev','ser_time','rev_time',
        'multi','def','dis','opr_type', 'bty'];
    protected $table = 'cln_m_services';

    public function cln_x_visits()
    {
        return $this->belongsToMany(cln_x_visits::class, 'cln_x_visits_services','service','visit_id');
    }
}
