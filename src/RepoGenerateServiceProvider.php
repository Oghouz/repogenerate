<?php

namespace Oghouz\RepoGenerate;

use Illuminate\Support\ServiceProvider;
use Oghouz\RepoGenerate\Console\Command\RepoGenerate;

class RepoGenerateServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

        $this->publishes([
            __DIR__.'/config/repository.php' => config_path('repository.php')
        ]);

        $this->commands('command.make.repository');
        $this->app->singleton('command.make.repository', function ($app) {
            return new RepoGenerate();
        });
    }


    public function provides()
    {
        return [
            'command.make.repository',
        ];
    }

}
