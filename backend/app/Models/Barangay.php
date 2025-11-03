<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barangay extends Model
{
    use HasFactory;

    protected $table = 'barangays';

    protected $fillable = [
        'name',
        'latitude',
        'longitude',
    ];

    public $timestamps = true;

    public function users()
    {
        return $this->hasMany(User::class);
    }
}