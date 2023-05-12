<?php

namespace App\Models\back;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cln_x_prev_icd10 extends Model
{
    use HasFactory;
    protected $fillable = ['visit', 'patient', 'opr_id','doc','date'];
    protected $table = 'cln_x_prev_icd10';


    public function date()
    {
        return $time =Carbon::parse($this->attributes['date'])->format('Y-m-d الساعة: h:i A');
    }
}
