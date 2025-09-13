<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Barangay;
use App\Models\Hospital;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'age',
        'barangay_id',
        'diagnosis',
        'hospital_id',
        'username',
        'email',
        'date_reported',
        'status',
    ];

    public function barangay()
    {
        return $this->belongsTo(Barangay::class);
    }

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }
}

