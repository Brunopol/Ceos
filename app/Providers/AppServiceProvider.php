<?php

namespace App\Providers;

use App\Models\Permission;
use App\Models\User;
use App\Observers\PermissionObserver;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

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
    public function boot()
    {
	Schema::defaultStringLength(191);
        Permission::observe(PermissionObserver::class);
        Gate::before(fn (User $user, $ability) => $user->hasPermissionTo($ability));

      
    }
}
