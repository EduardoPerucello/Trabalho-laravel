<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'psicologo_id', 
        'message', 
        'read'
    ];

    public function psicologo()
    {
        return $this->belongsTo(Psicologo::class);
    }
}
