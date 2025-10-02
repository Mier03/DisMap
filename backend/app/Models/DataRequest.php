<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'purpose',
        'requested_disease',
        'from_date',
        'to_date',
        'status',
    ];

    // Relationship to barangay if needed later
    public function barangay()
    {
        return $this->belongsTo(Barangay::class);
    }
}