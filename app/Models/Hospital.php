<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    use HasFactory;

    // Specify the table name since it’s not the default 'hospitals'
    protected $table = 'hospitals_table';

    // Specify which fields can be mass-assigned
    protected $fillable = [
        'name',
        'type',
    ];

    // Relationship: A hospital can have many doctors (users)
    public function users()
    {
        return $this->belongsToMany(User::class, 'doctor_hospital_table', 'hospital_id', 'user_id');
    }
}
