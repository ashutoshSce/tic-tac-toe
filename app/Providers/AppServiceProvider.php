<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }

        $this->registerServices();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the App services.
     *
     * @return void
     */
    protected function registerServices()
    {
        $services = [
            'Contracts\Repositories\BoardRepository' => 'Repositories\BoardRepository',
            'Contracts\Repositories\BoardMoveRepository' => 'Repositories\BoardMoveRepository',
            'Contracts\Services\GameService' => 'Services\GameService',
            'Contracts\Services\GameRuleService' => 'Services\GameRuleService',
        ];

        foreach ($services as $key => $value) {
            $this->app->singleton('App\\'.$key, 'App\\'.$value);
        }
    }
}
