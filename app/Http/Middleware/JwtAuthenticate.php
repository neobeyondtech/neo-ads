<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\JwtService;
use Exception;

class JwtAuthenticate
{
    protected JwtService $jwtService;

    public function __construct(JwtService $jwtService)
    {
        $this->jwtService = $jwtService;
    }

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $authHeader = $request->header('Authorization');

        if (!$authHeader) {
            return response()->json([
                'success' => false,
                'message' => 'Authorization header missing',
            ], 401);
        }

        $token = $this->jwtService->getTokenFromHeader($authHeader);

        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Bearer token missing',
            ], 401);
        }

        try {
            $payload = $this->jwtService->verifyToken($token);

            // Store the authenticated user data in the request
            $request->attributes->set('user', $payload);

            return $next($request);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized: ' . $e->getMessage(),
            ], 401);
        }
    }
}
