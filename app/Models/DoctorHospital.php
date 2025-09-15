<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorHospital extends Model
{
    use HasFactory;

    protected $table = 'doctor_hospitals';

    protected $fillable = [
        'doctor_id',
        'hospital_id',
    ];

    /**
     * Get the doctor associated with the record.
     */
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    /**
     * Get the hospital associated with the record.
     */
    public function hospital()
    {
        return $this->belongsTo(Hospital::class, 'hospital_id');
    }

    /**
     * Get the patient records associated with this doctor-hospital link.
     */
    public function patientRecords()
    {
        return $this->hasMany(PatientRecord::class, 'doctor_hospital_id');
    }
}