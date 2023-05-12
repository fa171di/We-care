<?php

namespace App\Models\back;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class expert_available_days extends Model
{
    use HasFactory;
    protected $fillable = ['expert_id','sun','mon','tue','wen','thu','fri','sat'];
    protected $table = 'expert_available_days';

}
