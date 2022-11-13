<?php

namespace Wefabric\AcronisLaravel\Providers;

use Illuminate\Support\ServiceProvider;

class AcronisLaravelServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/acronis.php' => config_path('acronis.php'),
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/acronis.php', 'acronis');
    }

}

