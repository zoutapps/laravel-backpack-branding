<?php

namespace Zoutapps\Laravel\Backpack\Branding;

use Illuminate\Support\ServiceProvider;
use Zoutapps\Laravel\Backpack\Branding\Commands\BrandingCommand;

class BrandingServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                BrandingCommand::class,
            ]);
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Branding::class, function () {
            return new Branding();
        });
        $this->app->alias(Branding::class, 'branding');
    }
}