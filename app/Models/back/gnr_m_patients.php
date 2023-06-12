<?php

namespace App\Models\back;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class gnr_m_patients extends Model
{
    use HasFactory;
    protected $fillable = ['l_name','f_name', 'ft_name',
        'mother_name','plc_birth','mobile','birth_date','sex',
        'phone','date','blood','p_city', 'p_area',
        'marital_status','title','nationality','address','user_id'];
    protected $table = 'gnr_m_patients';
    public $timestamps = FALSE;
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id', 'id')->withDefault();
    }

    public function gnr_m_patients_medical_info(): HasOne
    {
        return $this->hasOne(gnr_m_patients_medical_info::class,'patient', 'id');
    }

    public function gnr_m_cities():BelongsTo
    {
        return $this->belongsTo(gnr_m_cities::class,'p_city','id');
    }

    public function gnr_m_areas():BelongsTo
    {
        return $this->belongsTo(gnr_m_areas::class,'p_area','id');
    }

    public function gnr_m_nationality():BelongsTo
    {
        return $this->belongsTo(gnr_m_nationality::class,'nationality','id');
    }

    /*public function gnr_m_patients(){
        return $this->hasMany(gnr_m_patients::class, 'patient','id');
    }*/

    public function cln_m_medical_his()
    {
        return $this->belongsToMany(cln_m_medical_his::class, 'cln_x_medical_his','patient','med_id')->withPivot('cat','s_date','e_date','note','date');
    }

    public function cln_x_prev_com(){
        return $this->hasMany(cln_x_prev_com::class, 'patient','id');
    }

    public function cln_x_prev_str(){
        return $this->hasMany(cln_x_prev_str::class, 'patient','id');
    }

    public function cln_x_prev_cln(){
        return $this->hasMany(cln_x_prev_cln::class, 'patient','id');
    }

    public function cln_x_prev_not(){
        return $this->hasMany(cln_x_prev_not::class, 'patient','id');
    }

    public function cln_x_prev_dia(){
        return $this->hasMany(cln_x_prev_dia::class, 'patient','id');
    }

    public function wallet(){
        return $this->hasMany(wallet::class, 'patient_id','id')
            ->orderBy('id','desc');
    }
    public function getSex()
    {
        return $this->sex == 1 ? 'ذكر' : 'انثى';

    }

    public function getMarital_status()
    {
        if ($this->marital_status == 1){return $this->marital_status = 'متزوج';}
        elseif ($this->marital_status == 2){return $this->marital_status = 'اعزب';}
        elseif ($this->marital_status == 3){return $this->marital_status = 'مطلق';}
        elseif ($this->marital_status == 4){return $this->marital_status = 'ارمل';}
        elseif ($this->marital_status == 5){return $this->marital_status = 'منفصل';}
        elseif ($this->marital_status == 6){return $this->marital_status = 'مساكنة';}

    }

    public function getTitle()
    {
        if ($this->title == 1){return $this->title = 'السيد';}
        elseif ($this->title == 2){return $this->title = 'السيدة';}
        elseif ($this->title == 3){return $this->title = 'انسة';}
        elseif ($this->title == 4){return $this->title = 'دكتور';}
        elseif ($this->title == 5){return $this->title = 'طفل';}
        elseif ($this->title == 6){return $this->title = 'طفلة';}
        elseif ($this->title == 7){return $this->title = 'شاب';}

    }
    public function age()
    {
        return \Carbon\Carbon::parse($this->attributes['birth_date'])->diff(\Carbon\Carbon::now())->format('%y سنة و %m اشهر');

         //Carbon::parse($this->attributes['birth_date'])->age;
    }

}
