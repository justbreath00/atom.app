<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Services\JwtService;
use Symfony\Component\HttpFoundation\Response;

class CheckJWT
{
    public function __construct(
        private JwtService $jwtService
    ) {}

    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->cookie('jwt');

        if (!$token || !$this->jwtService->isValid($token)) {
            return redirect()->route('landing');
        }

        $this->refreshIfExpiringSoon($token);

        return redirect()->route('dashboard');
    }

    /**
     * If less than 7 days remain, silently reissue a fresh 30-day token
     * so active users never get logged out.
     */
    private function refreshIfExpiringSoon(string $token): void
    {
        $payload = $this->jwtService->decode($token);

        $sevenDays = 60 * 60 * 24 * 7;
        $thirtyDays = 60 * 60 * 24 * 30;

        if (($payload['exp'] - time()) < $sevenDays) {
            $newToken = $this->jwtService->generate(
                ['user_id' => $payload['user_id']],
                ttl: $thirtyDays
            );

            Cookie::queue('jwt', $newToken, $thirtyDays / 60); // Cookie::queue expects minutes
        }
    }
}