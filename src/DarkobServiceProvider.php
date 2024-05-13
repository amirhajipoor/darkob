<?php

namespace Amirhajipoor\Darkob;

use Illuminate\Support\ServiceProvider;

class DarkobServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('darkob', function () {
            return new Darkob();
        });
    }

    /**
     * Bootstrap any package services.
     */
    public function boot(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/darkob.php', 'darkob'
        );

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'darkob');

        $this->publishes([
            __DIR__.'/../resources/lang' => $this->app->langPath('vendor/darkob'),
            __DIR__.'/../config/darkob.php' => config_path('darkob.php'),
        ]);
    }
}
