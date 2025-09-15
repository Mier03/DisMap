<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientRecord extends Model
{
    use HasFactory;

    protected $table = 'patient_records';

    protected $fillable = [
        'patient_id',
        'disease_id',
        'doctor_hospital_id',
        'remarks',
    ];

    /**
     * Get the patient that owns the record.
     */
    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    /**
     * Get the disease for the record.
     */
    public function disease()
    {
        return $this->belongsTo(Disease::class, 'disease_id');
    }

    /**
     * Get the doctor-hospital record for the record.
     */
    public function doctorHospital()
    {
        return $this->belongsTo(DoctorHospital::class, 'doctor_hospital_id');
    }
}