<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema; 
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;



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
        Schema::defaultStringLength(191);
        $color_list = DB::table('colors')->get();
        $size_list  = DB::table('sizes')->get();
        $category_list  = DB::table('categories')->get();
        View::share('color_list', $color_list);
        View::share('size_list', $size_list);
        View::share('category_list', $category_list);


    }
}
