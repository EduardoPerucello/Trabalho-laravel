<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patients_id',
        'psicologo_id',
        'date',
        'time',
        'note'
    ];

    public function patients(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function psicologo(): BelongsTo
    {
        return $this->belongsTo(Psicologo::class);
    }
}
