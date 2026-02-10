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

    public function menus(): array
    {
         return match($this) {
            Role::SUPER_ADMIN => ['my-dashboard', 'user-management', 'reports', 'settings'],
            Role::ADMIN => [],
            Role::CUSTOMER => ['my-dashboard', 'my-ads', 'my-payment', 'my-profile', 'my-orders'],
            Role::PARTNER => [],
        };
    }

    public function privileges(): array
    {
        return match($this) {
            Role::SUPER_ADMIN => ['my-dashboard'=> ['all'], 'user-management' => ['all'], 'reports' => ['all'], 'settings' => ['all']],
            Role::ADMIN => [],
            Role::CUSTOMER => [
                'my-dashboard'=> ['all'], 
                'my-ads' => ['create', 'view', 'edit'],
                'my-payment' => ['view'], 
                'my-profile' => ['view', 'edit'], 
                'my-orders' => ['view']],
            Role::PARTNER => ['view-partner-data'],
        };
    }
}
