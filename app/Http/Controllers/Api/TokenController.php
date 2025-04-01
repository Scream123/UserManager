<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Token;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class TokenController extends Controller
{
    public function generateToken(): JsonResponse
    {
        $token = Str::random(80);

        Token::create([
            'token' => $token,
            'expires_at' => Carbon::now()->addMinutes(40),
            'used' => false,
        ]);

        return response()->json([
            'success' => true,
            'token' => $token,
            'message' => 'Token created successfully'
        ], 201);
    }
}
