<?php

namespace App\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use stdClass;
use Exception;

class JwtService
{
    private string $secret;
    private string $algorithm = 'HS256';

    public function __construct()
    {
        $this->secret = env('JWT_SECRET', 'your-secret-key-change-this');
    }

    /**
     * Generate a JWT token
     *
     * @param array $payload
     * @param int $expiresIn Token expiration time in seconds
     * @return string
     */
    public function generateToken(array $payload, int $expiresIn = 86400): string
    {
        $issuedAt = time();
        $expire = $issuedAt + $expiresIn;

        $tokenPayload = array_merge($payload, [
            'iat' => $issuedAt,
            'exp' => $expire,
        ]);

        return JWT::encode($tokenPayload, $this->secret, $this->algorithm);
    }

    /**
     * Verify and decode a JWT token
     *
     * @param string $token
     * @return stdClass|null
     * @throws Exception
     */
    public function verifyToken(string $token): ?stdClass
    {
        try {
            return JWT::decode($token, new Key($this->secret, $this->algorithm));
        } catch (Exception $e) {
            throw new Exception('Invalid token: ' . $e->getMessage());
        }
    }

    /**
     * Get token from Authorization header
     *
     * @param string $authHeader
     * @return string|null
     */
    public function getTokenFromHeader(string $authHeader): ?string
    {
        if (preg_match('/Bearer\s+(.+)/i', $authHeader, $matches)) {
            return $matches[1];
        }
        return null;
    }

    /**
     * Check if token is valid
     *
     * @param string $token
     * @return bool
     */
    public function isValid(string $token): bool
    {
        try {
            $this->verifyToken($token);
            return true;
        } catch (Exception) {
            return false;
        }
    }

    /**
     * Get payload from token
     *
     * @param string $token
     * @return stdClass|null
     */
    public function getPayload(string $token): ?stdClass
    {
        try {
            return $this->verifyToken($token);
        } catch (Exception) {
            return null;
        }
    }

    /**
     * Refresh token - generate new token with extended expiration
     *
     * @param string $token
     * @param int $expiresIn
     * @return string|null
     */
    public function refreshToken(string $token, int $expiresIn = 86400): ?string
    {
        try {
            $payload = $this->verifyToken($token);
            $payloadArray = (array) $payload;

            // Remove old expiration and issued-at time
            unset($payloadArray['iat'], $payloadArray['exp']);

            return $this->generateToken($payloadArray, $expiresIn);
        } catch (Exception) {
            return null;
        }
    }
}
