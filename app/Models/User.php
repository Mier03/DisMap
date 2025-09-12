<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
         'name',
        'hospital_name',
        'username',
        'email',
        'password',
        'certification',
        'user_type',
        'is_approved', 
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
            'is_approved' => 'boolean',
        ];
    }

    /**
     * Scope a query to only include admin users (Doctors).
     */
    public function scopeAdmins($query)
    {
        return $query->where('user_type', 'doctor');
    }

    /**
     * Scope a query to only include pending admin users.
     */
    public function scopePendingAdmins($query)
    {
        return $query->where('user_type', 'doctor')->where('is_approved', false);
    }

    /**
     * Scope a query to only include approved admin users.
     */
    public function scopeApprovedAdmins($query)
    {
        return $query->where('user_type', 'doctor')->where('is_approved', true);
    }

    /**
     * Scope a query to only include superadmin users.
     */
    public function scopeSuperAdmins($query)
    {
        return $query->where('user_type', 'admin');
    }
}
