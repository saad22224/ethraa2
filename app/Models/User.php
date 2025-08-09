<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use  HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'balance',
        'national_id_front',
        'national_id_back',
        'user_identifier',
        'type',
        'striga_customer_id',
        'country_code',
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


    public function tickets()
    {
        return $this->hasMany(Tiket::class);
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
    public function transfers()
    {
        return Transfer::where(function ($query) {
            $query->where('sender_id', $this->id)
                ->orWhere('recipient_id', $this->id);
        });
    }
}
