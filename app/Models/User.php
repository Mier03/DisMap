<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
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
        'birthdate',
        'barangay_id',
        'username',
        'email',
        'password',
        'certification',
        'user_type',
        'profile_image',
        'is_approved',
        'status',
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
    
    /**
     * Get the barangay that the user belongs to.
     */
    public function barangay()
    {
        return $this->belongsTo(Barangay::class);
    }
    
    /**
     * The hospitals that belong to the user (doctor).
     */
    public function hospitals()
    {
        return $this->belongsToMany(Hospital::class, 'doctor_hospitals', 'doctor_id', 'hospital_id')->withTimestamps();
    }

    /**
     * Get the doctor_hospital records for the doctor.
     */
    public function doctorHospitals()
    {
        return $this->hasMany(DoctorHospital::class, 'doctor_id');
    }

    /**
     * Get the patient records for the patient.
     */
    public function patientRecords()
    {
        return $this->hasMany(PatientRecord::class, 'patient_id');
    }

    // ----------------------------
    // SCOPES
    // ----------------------------

    /**
     * Scope a query to only include doctor users.
     */
    public function scopeAdmins($query)
    {
        return $query->where('user_type', 'Doctor');
    }

    /**
     * Scope a query to only include pending doctor users.
     */
    public function scopePendingAdmins($query)
    {
        return $query->where('user_type', 'Doctor')->where('is_approved', false);
    }

    /**
     * Scope a query to only include approved doctor users.
     */
    public function scopeApprovedAdmins($query)
    {
        return $query->where('user_type', 'Doctor')->where('is_approved', true);
    }

    /**
     * Scope a query to only include admin users.
     */
    public function scopeSuperAdmins($query)
    {
        return $query->where('user_type', 'Admin');
    }
}