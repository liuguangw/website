<?php

namespace App\Providers;

use App\Models\Topic;
use App\Observers\TopicObserver;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        DB::listen(function ($query) {
            Log::debug('sql', [$query->sql, $query->bindings, $query->time]);
            // $query->sql
            // $query->bindings
            // $query->time
        });
        Topic::observe(TopicObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
