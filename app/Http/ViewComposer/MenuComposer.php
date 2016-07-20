<?php

namespace App\Http\ViewComposer;

use Illuminate\View\View;
use App\Ibrol\Libraries\MenuLibrary;
use Gate;
use Cache;
use Auth;

class MenuComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $menu = new MenuLibrary;

        if(Auth::check()) {
            $data = Cache::get('datamenus-'.Auth::user()->user_id);
            $menucomposer = $menu->generateMenu($data);
        }else{
            $menucomposer = '';
        }


        $view->with('menucomposer', $menucomposer);
    }
}