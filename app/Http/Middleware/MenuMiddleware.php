<?php

namespace App\Http\Middleware;

use Closure;
use Cache;
use Gate;
use Auth;

use App\Ibrol\Libraries\Recursive;
use App\Ibrol\Libraries\MenuLibrary;
use App\Ibrol\Libraries\LogLibrary;
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
        if(!Cache::has('datamenus-'.Auth::user()->user_id)) {
            $menulibrary = new MenuLibrary;
            $datamenu = $menulibrary->getMenuFromDatabase();
            Cache::add('datamenus-'.Auth::user()->user_id,$datamenu,1440);
        }

        //store log
        $log = new LogLibrary;
        $log->store($request);

        return $next($request);
    }
}
