<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientRecord extends Model
{
    use HasFactory;

    protected $table = 'patient_records';

    public $timestamps = false; 
    const CREATED_AT = 'date_reported';
    const UPDATED_AT = 'date_recovered';
    protected $fillable = [
        'patient_id',
        'disease_id',
        'reported_dh_id',
        'reported_remarks',
        'recovered_dh_id',
        'recovered_remarks',
        'status',
        'date_reported', 
        'date_recovered',
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

    public function reportedByDoctorHospital()
    {
        return $this->belongsTo(DoctorHospital::class, 'reported_dh_id');
    }

    public function recoveredByDoctorHospital()
    {
        return $this->belongsTo(DoctorHospital::class, 'recovered_dh_id');
    }
}