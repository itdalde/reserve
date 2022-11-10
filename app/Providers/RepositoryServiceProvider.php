<?php

namespace App\Providers;

use App\Interfaces\OccasionEventInterface;
use App\Interfaces\OccasionEventPriceInterface;
use App\Repositories\OccasionEventPriceRepository;
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
        $this->app->bind(OccasionEventPriceInterface::class, OccasionEventPriceRepository::class);
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
