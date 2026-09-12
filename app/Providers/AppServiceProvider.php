<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use App\Models\Visitor;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        // Share visitor count with all views (Direct DB query without cache)
        View::composer('*', function ($view) {
            try {
                $visitorCount = Schema::hasTable('visitors') ? Visitor::count() : 0;
            } catch (\Throwable $e) {
                $visitorCount = 0;
            }
            $view->with('visitorCount', $visitorCount);
        });
    }
}