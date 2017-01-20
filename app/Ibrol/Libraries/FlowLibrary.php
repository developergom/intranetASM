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

	public function getNextFlow($flow_group_id, $flow_no, $user_id, $pic = '', $author = '', $manual_user = '')
	{
		$nextFlow = array();

		//counting flow
		if(Flow::where('flow_group_id', $flow_group_id)->where('flow_no', $flow_no  + 1)->where('active', '1')->count() > 0)
		{
			$flow = Flow::where('flow_group_id', $flow_group_id)->where('flow_no', $flow_no  + 1)->where('active', '1')->first();
			$nextUser = $this->getNextUser($flow->flow_by, $flow->role_id, $user_id, $pic, $author, $manual_user);
			//dd($flow);

			$nextFlow['flow_no'] = $flow->flow_no;
			$nextFlow['current_user'] = $nextUser;
		}else{
			$nextFlow['flow_no'] = 98;
			$nextFlow['current_user'] = $author;
		}


		return $nextFlow;
	}

	private function getNextUser($flow_by, $role_id, $user_id, $pic = '', $author = '', $manual_user = '') 
	{
		$nextUser = $author;

		if($flow_by == 'AUTHOR') 
		{
			$nextUser = $author;
		}elseif($flow_by == 'INDUSTRY')
		{

		}elseif($flow_by == 'MEDIA')
		{
			$currUser = User::find($user_id);
			$media_id = $currUser->medias[0]->media_id;
			$user = User::whereHas('medias',function($query) use($media_id){
				$query->where('medias.media_id','=',$media_id);
			})->whereHas('roles', function($query) use($role_id){
				$query->where('roles.role_id','=',$role_id);
			})->first();

			$nextUser = $user->user_id;
		}elseif($flow_by == 'PIC')
		{
			$nextUser = $pic;
		}elseif($flow_by == 'GROUP')
		{
			$currUser = User::find($user_id);
			$group_id = $currUser->groups[0]->group_id;
			$user = User::whereHas('groups',function($query) use($group_id){
				$query->where('groups.group_id','=',$group_id);
			})->whereHas('roles', function($query) use($role_id){
				$query->where('roles.role_id','=',$role_id);
			})->first();

			$nextUser = $user->user_id;
		}elseif($flow_by == 'MANUAL')
		{
			$nextUser = $manual_user;
		}

		return $nextUser;
	}

	public function getPreviousFlow($flow_group_id, $flow_no, $user_id, $pic = '', $author = '', $manual_user = '') {
		$prevFlow = array();

		$currentFlow = Flow::where('flow_group_id', $flow_group_id)->where('flow_no', $flow_no)->where('active', '1')->first();

		$flow = Flow::where('flow_group_id', $flow_group_id)->where('flow_no', $currentFlow->flow_prev)->where('active', '1')->first();
		$prevUser = $this->getNextUser($flow->flow_by, $flow->role_id, $user_id, $pic, $author, $manual_user);

		$prevFlow['flow_no'] = $flow->flow_no;
		$prevFlow['current_user'] = $prevUser;

		return $prevFlow;
	}
}