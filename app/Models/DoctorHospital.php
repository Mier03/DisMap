<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorHospital extends Model
{
    use HasFactory;

    protected $table = 'doctor_hospital_table'; // match your table name

    protected $fillable = [
        'user_id',
        'hospital_id',
        'status',
    ];
}
