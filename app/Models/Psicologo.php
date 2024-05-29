<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Psicologo extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'psicologo'; // Nome da tabela
    
    protected $fillable = [
        'full_name',
        'email',
        'password',
        'user_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'psicologo_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'psicologo_id');
    }
}
