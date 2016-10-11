<?php

namespace App\Ibrol\Libraries;

use App\Ibrol\Libraries\Recursive;
use App\Action;
use App\Menu;
use App\Module;
use App\Setting;

use Gate;
use Route;
use App\Http\Requests\Request;

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
        $datamenu = Menu::all();
        $datamodule = Module::with('actions')->get();

    	$data = array();
    	$i = 0;
    	foreach ($tmp as $key => $value) {
            $menu = $datamenu->where('menu_id', $key)->first();

    		$data[$i] = array();
    		$data[$i]['menu_id'] = $key;
    		$data[$i]['menu_name'] = $value;
    		$data[$i]['module_id'] = $menu->module_id;
    		$data[$i]['menu_parent'] = $menu->menu_parent;
    		$data[$i]['action'] = array();

            $modules = $datamodule->where('module_id', $menu->module_id)->first();
            $actions = $modules->actions->all();
    		foreach ($actions as $action) {
    			array_push($data[$i]['action'], $action->action_id);
    		}


    		$i++;
    	}
        
    	return $data;
    }

    public function getMenuFromDatabase()
    {
        $data = Menu::with('module')->where('active','1')->orderBy('menu_order','asc')->get();
        $recursive = new Recursive;
        $tmp = $recursive->data_recursive($data, 'menu_id', 'menu_parent', 0);

        return $tmp;
    }

    public function generateMenu($data)
    {
        $uri = '/' . Route::getCurrentRoute()->getPath();
        
        $menu = '<ul class="main-menu">';
        
        foreach($data as $key => $value) {
            //level 1
            if(count($value['sub']) > 0) {
                $obj = $value['data'];
                $active = ($obj->module->module_url==$uri) ? 'active toggled' : '';
                $icon = is_null($obj->menu_icon) ? 'zmdi zmdi-home' : $obj->menu_icon;
                $gateName1 = $obj->menu_name . '-Read';
                if(Gate::allows($gateName1)) {
                    $menu .= '<li class="sub-menu ' . $active . '"><a href="' . url('') . $obj->module->module_url . '"><i class="' . $icon . '"></i> ' . $obj->menu_name . '</a><ul>';
                }

                foreach($value['sub'] as $k => $v) {
                    //level 2
                    if(count($v['sub']) > 0) {
                        $obj = $v['data'];
                        $active = ($obj->module->module_url==$uri) ? 'active' : '';
                        $icon = is_null($obj->menu_icon) ? 'zmdi zmdi-home' : $obj->menu_icon;
                        $gateName2 = $obj->menu_name . '-Read';
                        if(Gate::allows($gateName2)) {
                            $menu .= '<li><a class="' . $active . '" href="' . url('') . $obj->module->module_url . '"><i class="' . $icon . '"></i> ' . $obj->menu_name . '</a><ul>';
                        }

                        foreach($v['sub'] as $k2 => $v2) {
                            //level 3
                            $obj = $v2['data'];
                            $active = ($obj->module->module_url==$uri) ? 'active' : '';
                            $icon = is_null($obj->menu_icon) ? 'zmdi zmdi-home' : $obj->menu_icon;
                            $gateName3 = $obj->menu_name . '-Read';
                            if(Gate::allows($gateName3)) {
                                $menu .= '<li><a class="' . $active . '" href="' . url('') . $obj->module->module_url . '"><i class="' . $icon . '"></i> ' . $obj->menu_name . '</a></li>';
                            }
                        }

                        //$gateName2 = $obj->menu_name . '-Read';
                        if(Gate::allows($gateName2)) {
                            $menu .= '</ul></li>';
                        }
                    }else{
                        $obj = $v['data'];
                        $active = ($obj->module->module_url==$uri) ? 'active' : '';
                        $icon = is_null($obj->menu_icon) ? 'zmdi zmdi-home' : $obj->menu_icon;
                        $gateName2 = $obj->menu_name . '-Read';
                        if(Gate::allows($gateName2)) {
                            $menu .= '<li><a class="' . $active . '" href="' . url('') . $obj->module->module_url . '"><i class="' . $icon . '"></i> ' . $obj->menu_name . '</a></li>';                        
                        }
                    }
                }

                //$gateName1 = $obj->menu_name . '-Read';
                if(Gate::allows($gateName1)) {
                    $menu .= '</ul></li>';
                }
            }else{
                $obj = $value['data'];
                $active = ($obj->module->module_url==$uri) ? 'active' : '';
                $icon = is_null($obj->menu_icon) ? 'zmdi zmdi-home' : $obj->menu_icon;
                $gateName1 = $obj->menu_name . '-Read';
                if(Gate::allows($gateName1)) {
                    $menu .= '<li class="' . $active . '"><a href="' . url('') . $obj->module->module_url . '"><i class="' . $icon . '"></i> ' . $obj->menu_name . '</a></li>';
                }
            }
        }

        $menu .= '</ul>';

        return $menu;
        //return $tmp;
    }
}