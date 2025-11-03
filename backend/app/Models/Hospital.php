<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    use HasFactory;

    protected $table = 'hospitals';

    protected $fillable = [
        'name',
        'type',
        'address',
    ];
    
    /**
     * Get the doctors associated with the hospital.
     */
    public function doctors()
    {
        return $this->belongsToMany(User::class, 'doctor_hospitals', 'hospital_id', 'doctor_id');
    }

    /**
     * Get the doctor_hospital records for the hospital.
     */
    public function doctorHospitals()
    {
        return $this->hasMany(DoctorHospital::class, 'hospital_id');
    }
}