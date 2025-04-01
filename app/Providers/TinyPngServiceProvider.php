<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\TinyPngService;

class TinyPngServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(TinyPngService::class, function ($app) {
            return new TinyPngService();
        });
    }

    public function boot()
    {
    }
}
