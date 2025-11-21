<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Wallet;
use App\Models\Transaction;
use App\Models\Badge;

class User extends Authenticatable implements MustVerifyEmail
{
    
    use HasFactory, Notifiable;

    
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'total_donated',
        'email_verification_code',
        'email_verification_expires_at',
    ];

    
    protected $hidden = [
        'password',
        'remember_token',
    ];

    
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'total_donated' => 'int',
            'email_verification_expires_at' => 'datetime',
        ];
    }
    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function badges()
    {
        return $this->belongsToMany(Badge::class);
    }

    protected static function booted()
    {
        static::created(function (User $user) {
            if (! $user->wallet()->exists()) {
                $user->wallet()->create(['balance' => 0]);
            }
        });
    }
}
