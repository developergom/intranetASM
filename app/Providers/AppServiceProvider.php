<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Setting;
use App\RolesModules;
use Cache;
use DB;

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

        if(!Cache::has('roles_modules')) {
            $roles_modules = DB::table('roles_modules')->get();
            Cache::add('roles_modules', $roles_modules, 1440);
            foreach ($roles_modules as $key => $value) {
                if(!Cache::has('roles_module_' . $value->role_id . '_' . $value->module_id . '_' . $value->action_id)) {
                    Cache::add('roles_module_' . $value->role_id . '_' . $value->module_id . '_' . $value->action_id, true, 1440);
                }
            }
            //Cache::add('roles_modules', DB::table('roles_modules')->get(), 1440);
        }

        //dd(Cache::get('roles_modules'));

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
