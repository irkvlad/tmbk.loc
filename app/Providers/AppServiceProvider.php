<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DB;

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
        //Отладка SQL запросов
        DB::listen(function ($query){ // TODO: Закоментирова отладчик SQL запросов
//            dump($query->sql);
//            dump($query->bindings);
        });
    }
}
