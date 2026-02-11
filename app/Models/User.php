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

    /**
     * Check if user has a specific permission based on their role
     */
    public function hasPermission(string $permission): bool
    {
        if (!$this->role) {
            return false;
        }

        return $this->role->hasPermission($permission);
    }

    /**
     * Check if user can perform an action on a resource
     */
    public function canPerform(string $action, string $resource, $resourceOwnerId = null): bool
    {
        if (!$this->role) {
            return false;
        }

        // Check if user has the permission for this action on the resource
        if (!$this->role->canPerform($action, $resource)) {
            return false;
        }

        // Additional ownership check for _own permissions
        if ($this->hasPermission("{$resource}.{$action}_own")) {
            // User can only perform action on their own resource
            return $resourceOwnerId === null || $resourceOwnerId == $this->id;
        }

        return true;
    }

    /**
     * Get user's privileges
     */
    public function getPrivileges(): array
    {
        if (!$this->role) {
            return [];
        }

        return $this->role->privileges();
    }
}