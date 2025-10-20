<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isGestor()
    {
        return $this->role === 'gestor';
    }

    public function isCliente()
    {
        return $this->role === 'cliente';
    }

    public function isPaciente(): bool { return $this->role === 'cliente'; }
    public function isMedico(): bool { return $this->role === 'gestor'; }

    public function appointmentsAsPatient()
    {
        return $this->hasMany(\App\Models\Appointment::class, 'patient_id');
    }

    public function appointmentsAsDoctor()
    {
        return $this->hasMany(\App\Models\Appointment::class, 'doctor_id');
    }


}
