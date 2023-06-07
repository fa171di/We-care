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


class Ads extends Model
{
    use HasFactory;
    protected $fillable = ['img','text','statue','created_at'];
    protected $table = 'ads';



    public function Statue()
    {
        return $this->statue == '0' ? 'غير منشور' : 'منشور';

    }

    public function time(){
        return Carbon::parse($this->attributes['created_at'])->format('Y, m, D h:i A');
    }
}
