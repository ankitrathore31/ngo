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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    // public function boot()
    // {
    //     require_once app_path('Helper/Helper.php');
    // }

    public function boot()
    {
        ini_set('upload_max_filesize', '20M');
        ini_set('post_max_size', '25M');
    }
}
