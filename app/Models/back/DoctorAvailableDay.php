<?php

namespace App\Models\back;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorAvailableDay extends Model
{
    use HasFactory;

    protected $table ='doctor_available_days';
    protected $fillable = [
        'doctor_id',
        'mon',
        'sun',
        'tue',
        'wen',
        'thu',
        'fri',
        'sat'
    ];
}
