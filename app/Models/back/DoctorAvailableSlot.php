<?php

namespace App\Models\back;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorAvailableSlot extends Model
{
    use HasFactory;

    protected $table = 'doctor_available_slots';

    protected $fillable = [
        'doctor_id',
        'doctor_available_time_id',
        'from',
        'to',
        'is_deleted'
    ];
    function appointment(){
        return $this->hasMany(Appointment::class,'available_slot','id');
    }
}
