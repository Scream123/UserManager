<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Token;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $response = Http::get(route('token.generate'));

        if ($response->failed()) {
            echo "Failed to generate token. Cannot create users.\n";
            return;
        }

        $token = $response->json('token');

        $userToken = Token::where('token', $token)->first();

        if (!$userToken) {
            echo "Invalid token. Cannot create users.\n";
            return;
        }

        if ($userToken->expires_at <= Carbon::now()) {
            echo "Token expired. Cannot create users.\n";
            return;
        }

        if ($userToken->used) {
            echo "Token already used. Cannot create users.\n";
            return;
        }

        $userToken->update(['used' => true]);

        User::factory(45)->create();

        echo "Users created successfully.\n";
    }
}
