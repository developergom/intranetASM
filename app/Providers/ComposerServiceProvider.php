<?php

namespace App\Providers;

use Auth;
use Illuminate\Support\ServiceProvider;
use App\Http\ViewComposers\MenuComposer;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        /*if(Auth::check()) {*/
            view()->composer(
                '*', 'App\Http\ViewComposer\MenuComposer'
            );    
        /*}*/
        
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
