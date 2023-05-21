<?php

namespace App\Models\back;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class DoctorAvailableDay extends Model
{
    use HasFactory;

    protected $table ='doctor_available_days';
    protected $fillable = [
        'doctor_id',
        'sun',
        'mon',
        'tue',
        'wen',
        'thu',
        'fri',
        'sat'
    ];

    public static function rules($id = 0)
    {
        return [
            'mon' => ['required_without_all:tue,wen,thu,fri,sat,sun'],
            'tue' => ['required_without_all:mon,wen,thu,fri,sat,sun'],
            'wen' => ['required_without_all:mon,tue,thu,fri,sat,sun'],
            'thu' => ['required_without_all:mon,wen,tue,fri,sat,sun'],
            'fri' => ['required_without_all:wen,tue,mon,thu,sat,sun'],
            'sat' => ['required_without_all:wen,tue,mon,thu,fri,sun'],
            'sun' => ['required_without_all:wen,tue,mon,thu,fri,sat'],
        ];
    }

    public static function messages()
    {
        return [
            'required_without_all:tue,wen,thu,fri,sat,sun' => 'you have to choice noe day at least ..',
            'required_without_all:mon,wen,thu,fri,sat,sun' => 'you have to choice noe day at least ..',
            'required_without_all:mon,tue,thu,fri,sat,sun' => 'you have to choice noe day at least ..',
            'required_without_all:mon,wen,tue,fri,sat,sun' => 'you have to choice noe day at least ..',
            'required_without_all:wen,tue,mon,thu,sat,sun' => 'you have to choice noe day at least ..',
            'required_without_all:wen,tue,mon,thu,fri,sun' => 'you have to choice noe day at least ..',
            'required_without_all:wen,tue,mon,thu,fri,sat' => 'you have to choice noe day at least ..',
        ];
    }
}
