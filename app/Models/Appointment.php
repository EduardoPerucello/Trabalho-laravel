<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'psicologo_id',
        'date',
        'time'
    ];

    // Defina relacionamentos, acessores, mutadores, etc., conforme necessário
}
