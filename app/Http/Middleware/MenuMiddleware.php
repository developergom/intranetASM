<?php

namespace App\Http\Middleware;

use Closure;
use Cache;
use Gate;

use App\Ibrol\Libraries\Recursive;
use App\Ibrol\Libraries\MenuLibrary;
use App\Http\Requests;

class MenuMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $menulibrary = new MenuLibrary;
        $menu = $menulibrary->generateMenu();
        Cache::add('menus',$menu,1);

        return $next($request);
    }
}
