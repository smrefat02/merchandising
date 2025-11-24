<?php

declare(strict_types=1);

namespace Applets\Merchandising\Providers;

use Illuminate\Support\ServiceProvider;

class MerchandisingServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $this->loadRoutesFrom(__DIR__ . '/../../routes/api.php');
    }
}
