<?php

namespace App\Ibrol\Libraries;

use App\Flow;
use App\FlowGroup;
use App\Module;
use App\User;
use App\Role;

use Route;

class FlowLibrary{
	public function getCurrentFlows($uri) 
	{
		//$uri = '/' . Route::getCurrentRoute()->getPath();

		$tmp = Module::where('module_url', $uri)->first()->flowgroup()->first()->flows()->where('active','1')->get();

		return $tmp;
	}

	public function getNextFlow($flow_group_id, $flow_no, $user_id, $pic = '', $author = '', $manual_user = '', $condition_value = 0)
	{
		$nextFlow = array();
		$nextFlow['flow_no'] = '';
		$nextFlow['url'] = '';
		$nextFlow['current_user'] = $user_id;
		$nextFlow['counter'] = 0;

		while (($nextFlow['current_user']==$user_id) && ($nextFlow['flow_no']!=98)) {
			//checking flow if it's using optional condition
			$currFlow = Flow::where('flow_group_id', $flow_group_id)->where('flow_no', $flow_no + 1)->first();
			//dd($currFlow);
			if(is_null($currFlow)){
				$currFlow = Flow::where('flow_group_id', $flow_group_id)->where('flow_no', $flow_no)->first();
			}

			$fn = $flow_no + 1;
			if($currFlow->flow_using_optional=='1') {
				//check optional condition
				switch ($currFlow->flow_condition) {
					case 'EQUAL':
						if($condition_value == $currFlow->flow_condition_value) {
							$fn = $currFlow->flow_next_optional;
						}else{
							$fn = $flow_no + 1;
						}
						break;
					
					case 'NOT_EQUAL':
						# code...
						if($condition_value <> $currFlow->flow_condition_value) {
							$fn = $currFlow->flow_next_optional;
						}else{
							$fn = $flow_no + 1;
						}
						break;

					case 'GREATER':
						# code...
						if($condition_value > $currFlow->flow_condition_value) {
							$fn = $currFlow->flow_next_optional;
						}else{
							$fn = $flow_no + 1;
						}
						break;

					case 'GREATER_EQUAL':
						# code...
						if($condition_value >= $currFlow->flow_condition_value) {
							$fn = $currFlow->flow_next_optional;
						}else{
							$fn = $flow_no + 1;
						}
						break;

					case 'LESS':
						# code...
						if($condition_value < $currFlow->flow_condition_value) {
							$fn = $currFlow->flow_next_optional;
						}else{
							$fn = $flow_no + 1;
						}
						//dd('sini');
						break;

					case 'LESS_EQUAL':
						# code...
						if($condition_value <= $currFlow->flow_condition_value) {
							$fn = $currFlow->flow_next_optional;
						}else{
							$fn = $flow_no + 1;
						}
						break;

					default:
						# code...
						$fn = $flow_no + 1;
						break;
				}
			}

			//counting flow
			if(Flow::where('flow_group_id', $flow_group_id)->where('flow_no', $fn)->where('active', '1')->count() > 0)
			{
				$flow = Flow::where('flow_group_id', $flow_group_id)->where('flow_no', $fn)->where('active', '1')->first();
				//dd($flow);
				$nextUser = $this->getNextUser($flow->flow_by, $flow->role_id, $user_id, $pic, $author, $manual_user);
				//dd($nextUser);

				$nextFlow['flow_no'] = $flow->flow_no;
				$nextFlow['url'] = $flow->flow_url;
				$nextFlow['current_user'] = $nextUser;
			}else{
				$nextFlow['flow_no'] = 98;
				$nextFlow['url'] = '';
				$nextFlow['current_user'] = $author;
			}

			$flow_no += 1;
			$nextFlow['counter'] += 1;
		}

		//dd($nextFlow);
		
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
			})->where('active', 1)->first();

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
			})->where('active', 1)->first();

			$nextUser = $user->user_id;
		}elseif($flow_by == 'MANUAL')
		{
			$nextUser = $manual_user;
		}

		if(User::where('active','0')->where('user_id', $nextUser)->count() > 0){
			//return superior of $nextUser;
			$s_u = User::find($nextUser);
			$s_group_id = $s_u->groups[0]->group_id;
			$s_role_id = $s_u->roles[0]->role_id;
			$s_roles = Role::find($s_role_id);
			$level_id = $s_roles->role_level_id;
			$superior = User::with('roles')->whereHas('groups', function($query) use($s_group_id) {
                                $query->where('groups.group_id','=',$s_group_id);
                            })->whereHas('roles', function($query) use($level_id) {
                                $query->where('roles.role_level_id', '>', $level_id);
                            })->where('users.active','=','1')->get();


            $least = 100; //karena level hanya sampai 7
            foreach ($superior as $key => $value) {
                if($value->roles[0]->role_level_id < $least){
                    $nextUser = $value->user_id;
                    $least = $value->roles[0]->role_level_id;
                }
            }
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

	public function getCurrentUrl($flow_group_id, $flow_no)
	{

		$flow = Flow::where('active','1')->where('flow_group_id',$flow_group_id)->where('flow_no',$flow_no)->first();

		return $flow->flow_url;
	}
}