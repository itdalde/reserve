<?php

namespace App\Providers;

use App\Interfaces\OccasionEventInterface;
use App\Repositories\OccasionEventRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind(OccasionEventInterface::class, OccasionEventRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
