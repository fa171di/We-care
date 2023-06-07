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


class wallet extends Model
{
    use HasFactory;
    protected $fillable = ['patient_id','value_changing','statue','prev_value','created_at'];
    protected $table = 'wallet';

    public function gnr_m_patients(){
        return $this->belongsTo(gnr_m_patients::class, 'patient_id','id');
    }

    public function Statue()
    {
        return $this->statue == '0' ? 'اضاف' : 'سحب';

    }

    public function time(){
        return Carbon::parse($this->attributes['created_at'])->format('Y-m-d الساعة: h:i A');
    }
}
