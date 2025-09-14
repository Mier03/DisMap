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
        'hospital_id', 
        'username',
        'email',
        'password',
        'certification',
        'user_type',
        'profile_image', 
        'is_approved', 
    ];
    // ----------------------------
        // RELATIONSHIPS
        // ----------------------------
        public function hospital()
        {
            return $this->belongsTo(Hospital::class, 'hospital_id'); 
            // 'hospital_id' is the foreign key in users table
        }

    /**
     * The hospitals that belong to the user (doctor).
     */
    public function hospitals()
    {
        return $this->belongsToMany(Hospital::class, 'doctor_hospital', 'user_id', 'hospital_id');
    }

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
        return $query->where('user_type', 'Doctor');
    }

    /**
     * Scope a query to only include pending admin users.
     */
    public function scopePendingAdmins($query)
    {
        return $query->where('user_type', 'Doctor')->where('is_approved', false);
    }

    /**
     * Scope a query to only include approved admin users.
     */
    public function scopeApprovedAdmins($query)
    {
        return $query->where('user_type', 'Doctor')->where('is_approved', true);
    }

    /**
     * Scope a query to only include superadmin users.
     */
    public function scopeSuperAdmins($query)
    {
        return $query->where('user_type', 'Admin');
    }
}
