<?php

namespace App\Providers;

use Auth;
use App\Ibrol\Libraries\RoleAccess;
use App\Menu;
use App\Action;
use App\Role;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        foreach($this->getMenus() as $key => $value) {
            foreach($value->module->actions as $action) {
                $gate->define($value->menu_name . '-' . $action->action_name, function($user) use ($value, $action) {
                    //dd(Auth::user()->user_id);
                    return RoleAccess::hasAccess(Auth::user()->user_id, $value->module_id, $action->action_id);
                });
            }
        }

        /*dd($gate);*/
        
        /*foreach($this->getRolesModules() as $rm) {
            $menu = Menu::where('module_id', $rm->module_id)->get()->first();
            $role = Role::find($rm->role_id);
            $action = Action::find($rm->action_id);
            //$gate->define($role->role_name . '-' . $menu->menu_name . '-' . $action->action_name, function($user) use ($role) {
            $gate->define($menu->menu_name . '-' . $action->action_name, function($user) use ($rm) {
                $menu = Menu::where('module_id', $rm->module_id)->get()->first();
                $role = Role::find($rm->role_id);
                $action = Action::find($rm->action_id);

                return $user->hasRole($role->role_name);
            });

        }*/

        //dd($gate);

    }

    public function getRolesModules()
    {
        return RolesModules::all();
    }

    public function getMenus()
    {
        return Menu::where('active', '1')->get();
        /*$menus = Menu::where('active', '1')->get();
        foreach ($menus as $key => $value) {
            dd($value->module->actions);
        }
        dd($r);*/
    }
}
