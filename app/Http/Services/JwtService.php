<?php

namespace App\Services;

class JwtService
{
    private string $secret;
    private string $algo = 'sha256';

    public function __construct()
    {
        // Put a long random string in .env: JWT_SECRET=xxxxx
        $this->secret = config('app.jwt_secret', env('JWT_SECRET'));
    }

   
    // Create a signed JWT for a given payload.
    // $ttl is lifetime in seconds (default 1 hour).
    
    public function generate(array $payload, int $ttl = 3600): string
    {
        $header = $this->base64UrlEncode(json_encode([
            'typ' => 'JWT',
            'alg' => 'HS256',
        ]));

        $payload['iat'] = time();
        $payload['exp'] = time() + $ttl;

        $payloadEncoded = $this->base64UrlEncode(json_encode($payload));

        $signature = $this->sign("$header.$payloadEncoded");

        return "$header.$payloadEncoded.$signature";
    }

    /**
     * Verify signature + expiry.
     */
    public function isValid(string $token): bool
    {
        $parts = explode('.', $token);

        if (count($parts) !== 3) {
            return false;
        }

        [$header, $payload, $signature] = $parts;

        $expectedSignature = $this->sign("$header.$payload");

        if (!hash_equals($expectedSignature, $signature)) {
            return false;
        }

        $decodedPayload = json_decode($this->base64UrlDecode($payload), true);

        if (!$decodedPayload || !isset($decodedPayload['exp'])) {
            return false;
        }

        if ($decodedPayload['exp'] < time()) {
            return false;
        }

        return true;
    }

    /**
     * Decode and return the payload (only call after isValid() passes).
     */
    public function decode(string $token): ?array
    {
        $parts = explode('.', $token);

        if (count($parts) !== 3) {
            return null;
        }

        return json_decode($this->base64UrlDecode($parts[1]), true);
    }

    private function sign(string $data): string
    {
        $hash = hash_hmac($this->algo, $data, $this->secret, true);

        return $this->base64UrlEncode($hash);
    }

    private function base64UrlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private function base64UrlDecode(string $data): string
    {
        $padded = str_pad($data, strlen($data) % 4 === 0 ? strlen($data) : strlen($data) + (4 - strlen($data) % 4), '=');

        return base64_decode(strtr($padded, '-_', '+/'));
    }
}