<?php

namespace App\Models\back;

use App\Models\ExpertAvailableSlot;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $table = 'appointments';

    protected $fillable = [
        'appointment_for',
        'appointment_with',
        'appointment_date',
        'appointment_time',
        'available_slot',
        'status',
        'is_deleted',
    ];

    function patient()
    {
        return $this->hasOne(User::class, 'id', 'appointment_for');
    }
    function doctor()
    {
        return $this->hasOne(User::class, 'id', 'appointment_with');
    }
    function timeSlot()
    {
        return $this->hasOne(DoctorAvailableSlot::class, 'id', 'available_slot');
    }
}
