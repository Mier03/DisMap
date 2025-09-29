<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disease extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'specification',
    ];

    /**
     * Get the patient records for the disease.
     */
    public function patientRecords()
    {
        return $this->hasMany(PatientRecord::class);
    }

    /**
     * The patients that have this disease.
     */
    public function patients()
    {
        return $this->belongsToMany(User::class, 'patient_records', 'disease_id', 'patient_id');
    }
}