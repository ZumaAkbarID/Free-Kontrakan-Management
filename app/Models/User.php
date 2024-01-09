<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];

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
        // 'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function ledger()
    {
        return $this->hasMany(Ledgers::class, 'user_id', 'id');
    }

    public function jadwalPiket()
    {
        return $this->hasMany(JadwalPiket::class, 'user_id', 'id');
    }

    public function piket()
    {
        return $this->hasOne(Piket::class, 'user_id', 'id');
    }

    public function talangan()
    {
        return $this->hasMany(Talangan::class, 'user_id', 'id');
    }
}
