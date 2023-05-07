<?php

namespace App\Models\back;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cln_x_prev_not_tmp extends Model
{
    use HasFactory;
    protected $fillable = ['doc','val','times'];
    protected $table = 'cln_x_prev_not_tmp';
}
