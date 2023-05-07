<?php

namespace App\Models\back;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cln_x_services_items extends Model
{
    use HasFactory;
    protected $fillable = ['visit', 'srv', 'iteme','qunt','r_qunt',
        't_price','status','date','doc','clinic'];
    protected $table = 'cln_x_services_items';
}
