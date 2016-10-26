<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Setting;
use Cache;

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
        if(!Cache::has('allSettings')) {
            $allSettings = Setting::where('active', '1')->get();

            Cache::add('allSettings', $allSettings, 43200); //monthly
            foreach ($allSettings as $key => $value) {
                if(!Cache::has('setting_' . $value->setting_code)) {
                    Cache::add('setting_' . $value->setting_code, $value->setting_value, 43200); //monthly
                }
            }
        }

        if(!\App::environment('local')) {
            \URL::forceSchema('https');
        }
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
