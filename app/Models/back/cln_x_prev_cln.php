<?php

namespace App\Models\back;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cln_x_prev_cln extends Model
{
    use HasFactory;
    protected $fillable = ['visit', 'patient', 'doc','val','date'];
    protected $table = 'cln_x_prev_cln';
}
