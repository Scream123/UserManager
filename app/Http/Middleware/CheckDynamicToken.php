<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Token;
use Closure;
use Illuminate\Http\Request;

class CheckDynamicToken
{
    public function handle(Request $request, Closure $next)
    {
        \Log::info('CheckDynamicToken Middleware has been triggered.');

        if ($request->isMethod('post') && $request->is('api/users')) {
            $token = $request->bearerToken();
            $token = Token::where('token', $token)->first();

            if (!$token) {
                return response()->json(['message' => 'Invalid token'], 401);
            }

            \Log::info('Token expires at: ' . $token->expires_at . ', current time: ' . now());

            if ($token->isExpired()) {
                \Log::info('Token expired.');
                return response()->json(['message' => 'Token expired'], 401);
            }

            if ($token->used) {
                \Log::info('Token already used.');
                return response()->json(['message' => 'Token already used'], 401);
            }

        }

        $response = $next($request);

        return $response;
    }
}
