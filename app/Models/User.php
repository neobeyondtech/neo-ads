<?php

namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\VerifyEmailIndo;
use App\Notifications\ResetPasswordIndo;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use App\Enums\Role;

class User extends Authenticatable implements MustVerifyEmail
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
        'remember_token',
        'photo',
        'role',
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

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailIndo);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordIndo($token));
    }

   //muttator role to enum
    public function getRoleAttribute($value): ?Role
    {
         return $value ? Role::from($value) : Role::CUSTOMER;
    }

    public function isAdmin(): bool
    {
        return $this->role === Role::ADMIN;
    }
}