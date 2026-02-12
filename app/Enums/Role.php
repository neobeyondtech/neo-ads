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
            Role::SUPER_ADMIN => [
                'my-dashboard'=> ['view'], 
                'user-management' => ['view', 'create', 'edit', 'delete'], 
                'reports' => ['all'],
                'settings' => ['view', 'create', 'edit', 'delete'],
                'advertisement' => ['view', 'create', 'edit', 'delete'],
                'advertisements' => ['view', 'create', 'edit', 'delete'],
                'customers' => ['view', 'create', 'edit', 'delete'],
                'partners' => ['view', 'create', 'edit', 'delete'],
                'transactions' => ['view', 'create', 'edit', 'delete'],
                'users' => ['view', 'create', 'edit', 'delete'],
                'payouts' => ['view', 'create', 'edit', 'delete'],
                'enrollments' => ['view', 'create', 'edit', 'delete'],
                'masterdata' => ['view', 'create', 'edit', 'delete'],
            ],
            Role::ADMIN => [
                'advertisements' => ['view', 'create', 'edit', 'delete'],
                'customers' => ['view', 'create', 'edit'],
                'partners' => ['view', 'create', 'edit'],
                'transactions' => ['view', 'create', 'edit'],
                'users' => ['view'],
                'payouts' => ['view', 'edit'],
                'enrollments' => ['view', 'create', 'edit'],
                'masterdata' => ['view'],
            ],
            Role::CUSTOMER => [
                'my-dashboard'=> ['view_own'], 
                'my-ads' => ['create', 'view_own', 'edit_own'],
                'my-payment' => ['view_own'], 
                'my-profile' => ['view_own', 'edit_own'], 
                'my-orders' => ['view_own', 'create'],
                'advertisement' => ['create', 'view_own', 'edit_own', 'delete_own']
            ],
            Role::PARTNER => [
                'advertisements' => ['view']
            ],
        };
    }

    /**
     * Check if role has a specific permission
     */
    public function hasPermission(string $permission): bool
    {
        $privileges = $this->privileges();
        
        // Split permission into resource and action (e.g., "advertisement.create")
        $parts = explode('.', $permission);
        if (count($parts) !== 2) {
            return false;
        }
        
        [$resource, $action] = $parts;
        
        // Check if resource exists and has the action
        if (!isset($privileges[$resource])) {
            return false;
        }
        
        return in_array($action, $privileges[$resource]);
    }

    /**
     * Check if role can perform an action on a resource
     */
    public function canPerform(string $action, string $resource): bool
    {
        return $this->hasPermission("{$resource}.{$action}");
    }
}
