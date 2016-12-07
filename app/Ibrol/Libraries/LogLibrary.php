<?php

namespace App\Ibrol\Libraries;

use BrowserDetect;
use Illuminate\Http\Request;

use App\Log;;
use App\User;

class LogLibrary{
	public function store(Request $request) {
		$browser = BrowserDetect::detect();

    	$log = new Log;
    	$log->log_url = $request->path();
    	$log->log_ip = $request->ip();
    	$log->log_os = $browser->osFamily;
        $log->log_device = $browser->deviceFamily;
    	$log->log_browser = $browser->browserFamily;
    	$log->created_by = $request->user()->user_id;
    	$log->save();
	}
}