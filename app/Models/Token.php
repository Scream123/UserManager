<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    protected $fillable = ['token', 'used', 'expires_at'];
    protected $dates = ['expires_at'];

    public function isExpired()
    {
        $expiresAt = Carbon::parse($this->expires_at);

        return $expiresAt->isPast();
    }
}
