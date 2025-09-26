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
        'requested_type',
        'requested_disease',
        'status',
        'handled_by_admin_id'
    ];

    // Relationship to admin who handled the request
    public function handledBy()
    {
        return $this->belongsTo(User::class, 'handled_by_admin_id');
    }

    // Relationship to barangay if needed later
    public function barangay()
    {
        return $this->belongsTo(Barangay::class);
    }
}