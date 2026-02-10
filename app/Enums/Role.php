<?php

namespace App\Enums;

enum Role: int
{
    case SUPER_ADMIN = 1;
    case ADMIN = 2;
    case CUSTOMER = 3;
    case PARTNER = 4;

    public function label(): string
    {
        return match($this) {
            Role::SUPER_ADMIN => 'Super Admin',
            Role::ADMIN => 'Admin',
            Role::CUSTOMER => 'Customer',
            Role::PARTNER => 'Partner',
        };
    }
}
