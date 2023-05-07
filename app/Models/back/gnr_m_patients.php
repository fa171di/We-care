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
    protected $fillable = ['f_name', 'l_name', 'ft_name',
        'mother_name','plc_birth',
        'no','mobile','birth_date','sex',
        'phone','date','blood','p_city', 'p_area', 'profession',
        'marital_status','title','nationality','reach_reference',
        'reach_reference_desc','address','user_id'];
    protected $table = 'gnr_m_patients';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id', 'id')->withDefault();;
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

    public function gnr_m_patients(){
        return $this->hasMany(gnr_m_patients::class, 'patient','id');
    }
    public function getSex()
    {
        return $this->sex == 1 ? 'ذكر' : 'انثى';

    }

    public function age()
    {
        return Carbon::parse($this->attributes['birth_date'])->age;
    }

}
