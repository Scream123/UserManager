<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ListUserRequest;
use App\Http\Requests\ShowUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\Token;
use App\Services\TinyPngService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(ListUserRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        $users = $this->userService->listUsers($validatedData['count'] ?? 6);

        return response()->json([
            'success' => true,
            'page' => $users->currentPage(),
            'total_pages' => $users->lastPage(),
            'total_users' => $users->total(),
            'count' => $users->count(),
            'links' => [
                'next_url' => $users->nextPageUrl(),
                'prev_url' => $users->previousPageUrl(),
            ],
            'users' => UserResource::collection($users),
        ]);
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $authHeader = $request->header('Authorization');

        if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
            return response()->json(['success' => false, 'message' => 'Token not found'], 401);
        }

        $tokenValue = substr($authHeader, 7);

        $token = Token::where('token', $tokenValue)->where('used', false)->first();

        if (!$token) {
            return response()->json(['success' => false, 'message' => 'Token is invalid or already used'], 403);
        }

        try {
            $user = $this->userService->createUser($validated);
            $token->update(['used' => true]);

            return response()->json([
                'success' => true,
                'user_id' => $user['id'],
                "message" => "New user successfully created"
            ], 201);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error creating user: ' . $e->getMessage()], 500);
        }
    }


    public function show(ShowUserRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $user = $this->userService->show((int)$validated['id'], false);

        return response()->json([
            'success' => true,
            'user' => new UserResource($user)
        ]);
    }
}
