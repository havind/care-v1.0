<?php

namespace App\Providers;

use App\Models\UserPermissions;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        Blade::if('authCheck', function ($permission) {
            $permissionValue = UserPermissions::select('value')
                ->where('permission', $permission)
                ->where('user_id', Auth::id())
                ->where('is_delete', 0)
                ->exists();

            if ($permissionValue == 1) {
                return true;
            }

        });
    }
}
