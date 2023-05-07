<?php

namespace App\Models\back;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cln_x_prev_icpc extends Model
{
    use HasFactory;
    protected $fillable = ['visit', 'patient', 'opr_id','doc','date'];
    protected $table = 'cln_x_prev_icpc';
}
