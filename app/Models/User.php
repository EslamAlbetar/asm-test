<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\AuthedPage;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'last_name',
        'email',
        'phone',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public function deductions()
    {
        return $this->hasMany(deduction::class);
    }

    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }

    public function vacations()
    {
        return $this->hasMany(Vacation::class);
    }

    public function shifts()
    {
        return $this->hasMany(Shift::class, 'id_user');
    }

    public function lastShift()
    {
        return $this->hasOne(Shift::class, 'id_user')->latestOfMany();
    }


    public function salaryCalculator()
    {
        return $this->hasOne(SalaryCalculator::class, 'id_user');
    }

    public function authedPage()
    {
        return $this->hasOne(AuthedPage::class, 'user_id');
    }

    public function partners()
    {
        return $this->hasMany(Partener::class, 'id_user');
    }

    public function usertype()
    {
        return $this->belongsTo(Usertype::class, 'usertype_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->id_user = $user->id_user ?? 0; // أو أي قيمة منطقية لك
        });
    }
}
