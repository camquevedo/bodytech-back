<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class UtilsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        require_once base_path() . '/app/Utils/CommonUtils.php';
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
