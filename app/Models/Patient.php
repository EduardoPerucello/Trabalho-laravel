<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Patient extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'full_name',
        'cep',
        'endereco',
        'bairro',
        'cidade',
        'estado',
        'phone',
        'user_id'
    ];
    
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'patients_id');
    }
}
