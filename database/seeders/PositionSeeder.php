<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = ['Manager', 'Developer', 'Designer', 'Tester', 'Support'];

        foreach ($positions as $position) {
            Position::create([
                'name' => $position,
            ]);
        }
    }
}
