<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PositionResource;
use App\Models\Position;
use Illuminate\Http\JsonResponse;

class PositionController extends Controller
{
    public function index(): JsonResponse
    {
        $positions = Position::all(['id', 'name']);

        if ($positions->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No positions found.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'positions' => PositionResource::collection($positions)
        ], 200);
    }
}
