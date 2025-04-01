<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService
{
    protected TinyPngService $tinyPngService;

    public function __construct(TinyPngService $tinyPngService)
    {
        $this->tinyPngService = $tinyPngService;
    }

    public function listUsers(int $limit, int $page): LengthAwarePaginator
    {
        return User::OrderBy('created_at', 'desc')->paginate($limit,['*'], 'page', $page);
    }

    public function createUser(array $data): User
    {
        if (isset($data['photo'])) {
            $imagePath = $data['photo']->getPathname();

            $sourceImage = imagecreatefromjpeg($imagePath);

            $cropWidth = 70;
            $cropHeight = 70;

            $croppedImage = imagecreatetruecolor($cropWidth, $cropHeight);

            imagecopyresampled($croppedImage, $sourceImage, 0, 0, 0, 0, $cropWidth, $cropHeight, imagesx($sourceImage), imagesy($sourceImage));

            $tempFilePath = storage_path('app/public/temp_photo.jpg');

            imagejpeg($croppedImage, $tempFilePath, 90);

            imagedestroy($sourceImage);
            imagedestroy($croppedImage);

            $compressedImageUrl = $this->tinyPngService->compressImage($tempFilePath);

            if ($compressedImageUrl) {
                unlink($tempFilePath);

                $data['photo'] = $compressedImageUrl;
            } else {
                $data['photo'] = $tempFilePath;
            }
        }

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'position_id' => $data['position_id'],
            'photo' => $data['photo'] ?? null,
        ]);
    }

    public function show(int $id, $isApi = false): JsonResponse|RedirectResponse|User
    {
        $user = User::find($id);

        if (!$user) {
            if ($isApi) {
                return response()->json([
                    'success' => false,
                    'message' => 'User found.'], 404);
            }

            return redirect()->route('users.index')->with('error', 'User not found');
        }

        if ($isApi) {
            return response()->json($user);
        }

        return $user;
    }
}
