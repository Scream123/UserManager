<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Token;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CleanExpiredTokens extends Command
{
    protected $signature = 'tokens:clean';
    protected $description = 'Clean expired tokens from the database';

    public function handle()
    {
        Token::where('expires_at', '<', Carbon::now())->delete();

        $this->info('Expired tokens cleaned successfully.');
    }
}
