<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'age',
        'hypertension',
        'heart_disease',
        'bmi',
        'HbA1c_level',
        'blood_glucose_level',
        'diabetes',
        'cluster'
    ];
}
