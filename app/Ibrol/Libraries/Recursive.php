<?php

namespace App\Ibrol\Libraries;

class Recursive{

	/**
	* Generate menu 
	*
	* @param array $data;
	* @param int $parent;
	* @param int $depth;
	*
	* @return array;
	*/
	public function menu_recursive($data, $parent, $depth)
	{
		$prefix = '';
		for($i = 1;$i <= $depth;$i++)
			$prefix .= '--';

		dd($data);
	}


	/**
	*
	* @param array $data
	* @param string $parent_name
	* @param string $sub_name
	* @param int $parent
	*
	* @return array
	*
	**/
	public function data_recursive($data = [], $parent_name = NULL, $sub_name = NULL, $parent = 0)
	{
		if(empty($data))
			return;

		$d = [];
		$dat = $data;
		if(!empty($dat))
		{
			foreach ($dat as $key => $val) {
				$id = $val[$parent_name];
				$parent_id = $val[$sub_name];
				$parent_id = (empty($parent_id)) ? 0 : $parent_id;

				if($parent == $parent_id)
				{
					$d[$id]['data'] = $val;
					unset($dat[$key]);
					$d[$id]['sub'] = $this->data_recursive($dat, $parent_name, $sub_name, $id);
				}
			}
		}

		return $d;
	}


	/**
	* 
	* @param array $data
	* @param int $value
	* @param string $label
	* @param int $default_option
	* @param array $arr_option
	* @param int $depth
	*
	* @return array
	*
	**/
	public function option_recursive($data = [], $value = NULL, $label = NULL, $default_option = NULL, $arr_option = [], $depth = 0)
	{
		$separator = NULL;
		for($i = 0; $i < $depth; $i++)
			$separator .= '---';

		if(!empty($default_option))
		{
			if(is_array($default_option))
			{
				foreach($default_option as $key => $val)
					$arr_option[$key] = $val;
			}
			else
			{
				$arr_option[0] = $default_option;
			}
		}

		if(!empty($data))
		{
			foreach ($data as $val) {
				$d = $val['data'];
				$arr_option[$d[$value]] = $separator . $d[$label];
				if(!empty($val['sub']))
				{
					$newdepth = $depth + 1;
					$arr_option = $this->option_recursive($val['sub'], $value, $label, NULL, $arr_option, $newdepth);
				}
			}
		}

		return $arr_option;
	}
}