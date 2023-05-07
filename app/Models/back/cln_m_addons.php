<?php

namespace App\Models\back;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cln_m_addons extends Model
{
    use HasFactory;
    protected $fillable = ['code', 'icon', 'name_ar','name_en','addon',
        'clinic','service','req_load','req',
        'ord','short_code','act','color', 'created_at', 'updated_at'];
    protected $table = 'cln_m_addons';

}
