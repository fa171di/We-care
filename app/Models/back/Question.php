<?php

namespace App\Models\back;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Question extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','Question','answer','section','created_at'];
    protected $table = 'question';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id', 'id')->withDefault();
    }

    public function gnr_m_clinics()
    {
        return $this->belongsTo(gnr_m_clinics::class, 'section','id');
    }


}
