<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Cache;
use Gate;
use App\Http\Requests;

class CacheManagementController extends Controller
{
    public function index() {
    	if(Gate::denies('Cache Management-Read')) {
            abort(403, 'Unauthorized action.');
        }

        return view('vendor.material.config.cache.index');
    }

    public function apiClearAll(Request $request) {
    	if(Gate::denies('Cache Management-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $x = Cache::flush();

        return 200;
    }
}
