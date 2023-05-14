<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\back\doctors;
use App\Models\back\gnr_m_patients;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
//use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'roles_name',
        'verification_code',
        'Status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'roles_name'=>'array',
    ];

    public function doctor(): HasOne
    {
        return $this->hasOne(doctors::class,'user_id', 'id');
    }

    public function gnr_m_patients(): HasOne
    {
        return $this->hasOne(gnr_m_patients::class,'user_id', 'id');
    }

    public static function rules($id = 0)
    {
        return [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ];
    }

    public static function messages()
    {
        return [
            'required' => 'this field(:attribute) is required',
            'email.unique' => 'الايميل موجود مسبقا',
            'email.email' => 'صيغة الايميل غير صحيحة',
            'password.same' => 'تأكيد كلمة السر غير صحيحة',
        ];
    }

}
