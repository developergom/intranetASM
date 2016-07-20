<?php

namespace App\Ibrol\Libraries;

use App\Ibrol\Libraries\Recursive;
use App\Action;
use App\Menu;
use App\Module;

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

    public function getMenuFromDatabase()
    {
        $data = Menu::where('active','1')->orderBy('menu_order','asc')->get();
        $recursive = new Recursive;
        $tmp = $recursive->data_recursive($data, 'menu_id', 'menu_parent', 0);

        return $tmp;
    }

    public function generateMenu($data)
    {
        /*dd(Route::getCurrentRoute()->getPath());*/
        /*if(Gate::allows('Media Management-Read')) {
            dd('soni');
        }else{
            dd('sino');
        }*/

        
        $menu = '<ul class="main-menu">';
        
        foreach($data as $key => $value) {
            //level 1
            if(count($value['sub']) > 0) {
                $active = '';
                $obj = $value['data'];
                $icon = is_null($obj->menu_icon) ? 'zmdi zmdi-home' : $obj->menu_icon;
                $gateName = $obj->menu_name . '-Read';
                if(Gate::allows($gateName)) {
                    $menu .= '<li class="sub-menu ' . $active . '"><a href="' . url('') . $obj->module->module_url . '"><i class="' . $icon . '"></i> ' . $obj->menu_name . '</a><ul>';
                }

                foreach($value['sub'] as $k => $v) {
                    //level 2
                    if(count($v['sub']) > 0) {
                        $active = '';
                        $obj = $v['data'];
                        $icon = is_null($obj->menu_icon) ? 'zmdi zmdi-home' : $obj->menu_icon;
                        $gateName = $obj->menu_name . '-Read';
                        if(Gate::allows($gateName)) {
                            $menu .= '<li class="' . $active . '"><a href="' . url('') . $obj->module->module_url . '"><i class="' . $icon . '"></i> ' . $obj->menu_name . '</a><ul>';
                        }

                        foreach($v['sub'] as $k2 => $v2) {
                            //level 3
                            $active = '';
                            $obj = $v2['data'];
                            $icon = is_null($obj->menu_icon) ? 'zmdi zmdi-home' : $obj->menu_icon;
                            $gateName = $obj->menu_name . '-Read';
                            if(Gate::allows($gateName)) {
                                $menu .= '<li class="' . $active . '"><a href="' . url('') . $obj->module->module_url . '"><i class="' . $icon . '"></i> ' . $obj->menu_name . '</a></li>';
                            }
                        }


                        if(Gate::allows($gateName)) {
                            $menu .= '</ul></li>';
                        }
                    }else{
                        $active = '';
                        $obj = $v['data'];
                        $icon = is_null($obj->menu_icon) ? 'zmdi zmdi-home' : $obj->menu_icon;
                        $gateName = $obj->menu_name . '-Read';
                        if(Gate::allows($gateName)) {
                            $menu .= '<li class="' . $active . '"><a href="' . url('') . $obj->module->module_url . '"><i class="' . $icon . '"></i> ' . $obj->menu_name . '</a></li>';                        
                        }
                    }
                }

                $gateName = $obj->menu_name . '-Read';
                if(Gate::allows($gateName)) {
                    $menu .= '</ul></li>';
                }
            }else{
                //$active = (Request::segment(1)=='') ? 'active' : '';
                $active = '';
                $obj = $value['data'];
                $icon = is_null($obj->menu_icon) ? 'zmdi zmdi-home' : $obj->menu_icon;
                $gateName = $obj->menu_name . '-Read';
                if(Gate::allows($gateName)) {
                    $menu .= '<li class="' . $active . '"><a href="' . url('') . $obj->module->module_url . '"><i class="' . $icon . '"></i> ' . $obj->menu_name . '</a></li>';
                }
            }
        }

        $menu .= '</ul>';

        return $menu;
        //return $tmp;
    }
}