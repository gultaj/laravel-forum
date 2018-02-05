<?php

namespace App\Providers;

use App\Channel;
use App\Thread;
use App\Reply;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \View::composer('*', function($view) {
            $channels = \Cache::rememberForever('channels', function () {
                return Channel::all();
            });
            $view->with('channels', $channels);
        });

        Relation::morphMap([
            'thread' => Thread::class,
            'reply' => Reply::class,
            'favorite' => \App\Favorite::class,
            'user' => \App\User::class,
        ]);

        \Validator::extend('spamfree', 'App\Rules\SpamFree@passes');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }
        if (!is_null(env('SCOUT_DRIVER'))) {
            $this->app->register(\Laravel\Scout\ScoutServiceProvider::class);
            $this->app->register(\ScoutEngines\Elasticsearch\ElasticsearchProvider::class);
        }
    }
}
