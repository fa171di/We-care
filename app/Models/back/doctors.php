<?php

namespace App\Models\back;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Query\Builder;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;


class doctors extends Model
{
    use HasFactory;
    protected $fillable = ['act','famous','name_ar','subgrp','sex','specialization_ar'
        ,'to_time','slot_time', 'from_time','user_id','phone_number','photo','total_rate','revisions_num'];
    protected $table = 'doctors';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id', 'id')->withDefault();
    }

    public function gnr_m_clinics()
    {
        return $this->belongsTo(gnr_m_clinics::class, 'subgrp','id');
    }

    public function cln_x_prev_com(){
        return $this->hasMany(cln_x_prev_com::class, 'doc','id');
    }

    public function available_days(){
        return $this->hasMany(DoctorAvailableDay::class, 'doctor_id','id');
    }

    public function cln_x_prev_str(){
        return $this->hasMany(cln_x_prev_str::class, 'doc','id');
    }
    public function cln_x_prev_cln(){
        return $this->hasMany(cln_x_prev_cln::class, 'doc','id');
    }
    public function cln_x_prev_not(){
        return $this->hasMany(cln_x_prev_not::class, 'doc','id');
    }
    public function cln_x_prev_dia(){
        return $this->hasMany(cln_x_prev_dia::class, 'doc','id');
    }
    public function scopeSelection($query)
    {
        return $query->select('act','famous','name_ar','subgrp','sex','specialization_ar','title_ar'
            ,'to_time','slot_time', 'from_time','user_id','phone_number','photo');
    }

    public function getsSex()
    {
        return $this->sex == '1' ? 'دكتور' : 'دكتورة';

    }

    public function getFamous()
    {
        return $this->famous == '0' ? 'غير معروف' : 'معروف';

    }
    public function getAct()
    {
        return $this->act == '1' ? 'ضمن الدوام' : 'خارج الدوام';

    }
    /*public function setStatusAttribute($value) {
       if($value == 'ضمن الدوام'){
           $this->attributes['status'] = 'active';
       }
   }*/

    /*public function age()
    {
        return Carbon::parse($this->attributes['birthday'])->age;
    }*/


    public static function rules($id = 0)
    {
        return [
            'name_ar' => ['required', 'string', 'max:255'],
            'to_time'=>['required'],
            'slot_time'=>['required'],
            'from_time'=>['required'],
            'specialization_ar'=>['required'],
            'phone_number'=>['required'],
            'sex'=>['required'],
            'act'=>['required'],
            'photo'=>[File::image()->types(['png', 'jpg', 'jpeg'])->min(1024)->max(12 * 1024)
                ->dimensions(
                    Rule::dimensions()
                        ->maxWidth(1000)
                        ->maxHeight(500)
                )],
        ];
    }

    public static function messages()
    {
        return [
            'required' => 'this field(:attribute) is required',
            'photo.types' => 'img must be png jpg jpeg',
            'photo.dimensions.maxWidth' => 'fff maxWidth',
            'photo.dimensions.maxHeight' => 'fff maxHeight',

        ];
    }
}
