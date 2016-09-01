<?php

namespace App\Ibrol\Libraries;

use App\Flow;
use App\FlowGroup;
use App\Module;

use Route;

class FlowLibrary{
	public function getCurrentFlows($uri) 
	{
		//$uri = '/' . Route::getCurrentRoute()->getPath();

		$tmp = Module::where('module_url', $uri)->first()->flowgroup()->first()->flows()->where('active','1')->get();

		return $tmp;
	}
}