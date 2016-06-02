<?php

namespace App\Ibrol\Libraries;

use App\Ibrol\Libraries\Recursive;
use App\Action;
use App\Menu;
use App\Module;

class MenuLibrary{

	/**
    *
    * @return array
    **/
    public function generateListMenu()
    {
        $data = Menu::where('active','1')->orderBy('menu_order','asc')->get();
        $recursive = new Recursive;
        $tmp = $recursive->data_recursive($data, 'menu_id', 'menu_parent', 0);
        $options = $recursive->option_recursive($tmp,'menu_id','menu_name',NULL,[],0);
        return $options;   
    }

    /**
    *
    * @return array
    *
    **/
    public function generateListModule()
    {
    	$tmp = $this->generateListMenu();
    	//dd($tmp);

    	$data = array();
    	$i = 0;
    	foreach ($tmp as $key => $value) {
    		$menu = Menu::find($key);

    		$data[$i] = array();
    		$data[$i]['menu_id'] = $key;
    		$data[$i]['menu_name'] = $value;
    		$data[$i]['module_id'] = $menu->module_id;
    		$data[$i]['menu_parent'] = $menu->menu_parent;
    		$data[$i]['action'] = array();

    		$modules = Module::find($menu->module_id);
    		foreach ($modules->actions as $action) {
    			array_push($data[$i]['action'], $action->action_id);
    		}


    		$i++;
    	}

    	//dd($data);
    	return $data;
    }
}