<?php

namespace App\Ibrol\Libraries;

use App\Flow;
use App\FlowGroup;
use App\Module;
use App\User;

use Route;

class FlowLibrary{
	public function getCurrentFlows($uri) 
	{
		//$uri = '/' . Route::getCurrentRoute()->getPath();

		$tmp = Module::where('module_url', $uri)->first()->flowgroup()->first()->flows()->where('active','1')->get();

		return $tmp;
	}

	public function getNextFlow($flow_group_id, $flow_no, $user_id, $PIC = '')
	{
		$nextFlow = array();

		$flow = Flow::where('flow_group_id', $flow_group_id)->where('flow_no', $flow_no  + 1)->first();
		//dd($flow);

		$nextFlow['flow_no'] = $flow->flow_no;
	}

	private function getNextUser($flow_by, $role_id, $user_id) 
	{
		if($flow_by == 'AUTHOR') 
		{

		}elseif($flow_by == 'INDUSTRY')
		{

		}elseif($flow_by == 'MEDIA')
		{

		}elseif($flow_by == 'PIC')
		{

		}elseif($flow_by == 'GROUP')
		{

		}
	}
}