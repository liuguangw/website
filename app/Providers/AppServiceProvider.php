<?php

namespace App\Providers;

use App\Models\Forum;
use App\Models\Reply;
use App\Models\Topic;
use App\Models\TopicContent;
use App\Observers\ForumObserver;
use App\Observers\ReplyObserver;
use App\Observers\TopicContentObserver;
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
        Forum::observe(ForumObserver::class);
        Topic::observe(TopicObserver::class);
        TopicContent::observe(TopicContentObserver::class);
        Reply::observe(ReplyObserver::class);
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
