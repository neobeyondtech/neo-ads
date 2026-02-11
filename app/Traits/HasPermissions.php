<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait HasPermissions
{
    /**
     * Check if the authenticated user has the required permission
     */
    protected function checkPermission(string $permission): bool
    {
        $user = auth()->user();
        
        if (!$user) {
            return false;
        }
        
        return $user->hasPermission($permission);
    }

    /**
     * Check if user can perform action on resource
     */
    protected function canPerform(string $action, string $resource, $resourceOwnerId = null): bool
    {
        $user = auth()->user();
        
        if (!$user) {
            return false;
        }
        
        return $user->canPerform($action, $resource, $resourceOwnerId);
    }

    /**
     * Return unauthorized response
     */
    protected function unauthorizedResponse(string $message = 'Unauthorized access'): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'status' => 'error',
            'status_code' => 403,
        ], 403);
    }

    /**
     * Check permission and return error response if unauthorized
     */
    protected function authorizeAction(string $permission, string $errorMessage = null): ?JsonResponse
    {
        if (!$this->checkPermission($permission)) {
            return $this->unauthorizedResponse($errorMessage ?? "You don't have permission to perform this action.");
        }
        
        return null;
    }

    /**
     * Check resource-specific permission
     */
    protected function authorizeResourceAction(string $action, string $resource, $resourceOwnerId = null, string $errorMessage = null): ?JsonResponse
    {
        if (!$this->canPerform($action, $resource, $resourceOwnerId)) {
            return $this->unauthorizedResponse($errorMessage ?? "You don't have permission to {$action} this {$resource}.");
        }
        
        return null;
    }

    /**
     * Check view permission and apply ownership filtering
     * Returns: 'all' if user can view all, 'own' if user can view only own, null if no permission
     */
    protected function getViewPermissionLevel(string $resource): ?string
    {
        $user = auth()->user();
        
        if (!$user) {
            return null;
        }
        
        if ($user->hasPermission("{$resource}.view")) {
            return 'all';
        } elseif ($user->hasPermission("{$resource}.view_own")) {
            return 'own';
        } 
        
        return null;
    }

    /**
     * Apply ownership filter to query builder based on view permission
     */
    protected function applyViewPermissionFilter($builder, string $resource): ?JsonResponse
    {
        $permissionLevel = $this->getViewPermissionLevel($resource);
        
        if ($permissionLevel === null) {
            return $this->unauthorizedResponse("You don't have permission to view {$resource}s.");
        }
        
        if ($resource == 'notification') {
            // Notifications are filtered by recipient_id
            if ($permissionLevel === 'own' || $permissionLevel === 'group') {
                $user = auth()->user();
                $builder->where('recipient_id', $user->id);
            }
            return null; // No error, continue with the query
        }
        if ($permissionLevel === 'own') {
            $user = auth()->user();
            $builder->where('users_id', $user->id);
        } elseif ($permissionLevel === 'group') {
            $user = auth()->user();
            $builder->whereHas('groups', function ($query) use ($user) {
                $query->where('users_id', $user->id);
            });
            $builder->orWhere('users_id', $user->id);
        }
        
        return null; // No error, continue with the query
    }

    /**
     * Check if user can view a specific resource instance
     */
    protected function authorizeViewResource(string $resource, $resourceOwnerId): ?JsonResponse
    {
        $permissionLevel = $this->getViewPermissionLevel($resource);
        
        if ($permissionLevel === null) {
            return $this->unauthorizedResponse("You don't have permission to view {$resource}s.");
        }
        
        if ($permissionLevel === 'own') {
            $user = auth()->user();
            if ($resourceOwnerId !== $user->id) {
                return $this->unauthorizedResponse("You don't have permission to view this {$resource}.");
            }
        }
        
        return null; // No error, user can view this resource
    }
}