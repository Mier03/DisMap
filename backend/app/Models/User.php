<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;   // 👈 Add this

class User extends Authenticatable 
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;  // 👈 Add HasApiTokens here

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'birthdate',
        'barangay_id',
        'username',
        'email',
        'password',
        'user_type',
        'profile_image',
        'is_approved',
        'status',
        'sex', 
        'ethnicity',
        'street_address', 
        'contact_number',
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
            'birthdate' => 'date', 
        ];
    }
    
    // ----------------------------
    // RELATIONSHIPS
    // ----------------------------
    
    public function barangay()
    {
        return $this->belongsTo(Barangay::class);
    }
    
    public function hospitals()
    {
        return $this->belongsToMany(Hospital::class, 'doctor_hospitals', 'doctor_id', 'hospital_id')
            ->withTimestamps()
            ->withPivot('certification', 'status');
    }

    public function approvedHospitals()
    {
        return $this->hospitals()->wherePivot('status', 'approved');
    }

    public function doctorHospitals()
    {
        return $this->hasMany(DoctorHospital::class, 'doctor_id');
    }

    public function patientRecords()
    {
        return $this->hasMany(PatientRecord::class, 'patient_id');
    }

    // ----------------------------
    // SCOPES
    // ----------------------------

    public function scopeAdmins($query)
    {
        return $query->where('user_type', 'Doctor');
    }

    public function scopePendingAdmins($query)
    {
        return $query->where('user_type', 'Doctor')->where('is_approved', false);
    }

    public function scopeApprovedAdmins($query)
    {
        return $query->where('user_type', 'Doctor')->where('is_approved', true);
    }

    public function scopeSuperAdmins($query)
    {
        return $query->where('user_type', 'Admin');
    }
}
