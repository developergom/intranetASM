<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;
use App\Menu;
use App\Module;

use App\Ibrol\Libraries\Recursive;

class MenuController extends Controller
{
    protected $searchPhrase = '';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('vendor.material.master.menu.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $data = array();

        $data['modules'] = Module::where('active','1')->get();
        $data['parents'] = $this->generateParentOption();

        return view('vendor.material.master.menu.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'menu_name' => 'required|max:100',
            'module_id' => 'required|unique:menus,module_id',
            'menu_parent' => 'required|numeric',
            'menu_order' => 'required|numeric',
        ]);

        //reorder menu
        $this->reorderMenu($request, 'ADD', $request->input('menu_parent'), $request->input('menu_order'));

        $obj = new Menu;
        $obj->menu_name = $request->input('menu_name');
        $obj->module_id = $request->input('module_id');
        $obj->menu_parent = $request->input('menu_parent');
        $obj->menu_order = $request->input('menu_order');
        $obj->menu_desc = $request->input('menu_desc');
        $obj->active = '1';
        $obj->created_by = $request->user()->user_id;

        $obj->save();

        $request->session()->flash('status', 'Data has been saved!');

        return redirect('master/menu');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $data = array();

        $data['menu'] = Menu::find($id);
        $data['modules'] = Module::where('active','1')->get();
        $data['parents'] = $this->generateParentOption();
        $data['count'] = Menu::where('active', '1')->where('menu_parent', $data['menu']->menu_parent)->count();

        return view('vendor.material.master.menu.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $data = array();

        $data['menu'] = Menu::find($id);
        $data['modules'] = Module::where('active','1')->get();
        $data['parents'] = $this->generateParentOption();
        $data['count'] = Menu::where('active', '1')->where('menu_parent', $data['menu']->menu_parent)->count();

        return view('vendor.material.master.menu.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $this->validate($request, [
            'menu_name' => 'required|max:100',
            'module_id' => 'required|unique:menus,module_id,'.$id.',menu_id',
            'menu_parent' => 'required|numeric',
            'menu_order' => 'required|numeric',
        ]);


        $obj = Menu::find($id);

        //reorder menu
        if($request->input('menu_order') > $obj->menu_order)
        {
            $direction = 'TOUPPER';
        }
        else
        {
            $direction = 'TOLOWER';
        }

        $this->reorderMenu($request, 'UPDATE', $request->input('menu_parent'), $request->input('menu_order'), $direction, $obj->menu_order);

        $obj->menu_name = $request->input('menu_name');
        $obj->module_id = $request->input('module_id');
        $obj->menu_parent = $request->input('menu_parent');
        $obj->menu_order = $request->input('menu_order');
        $obj->menu_desc = $request->input('menu_desc');
        $obj->updated_by = $request->user()->user_id;

        $obj->save();

        $request->session()->flash('status', 'Data has been updated!');

        return redirect('master/menu');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function apiList(Request $request)
    {
        $current = $request->input('current') or 1;
        $rowCount = $request->input('rowCount') or 5;
        $skip = ($current==1) ? 0 : (($current - 1) * $rowCount);
        $this->searchPhrase = $request->input('searchPhrase') or '';
        
        $sort_column = 'menu_id';
        $sort_type = 'asc';

        if(is_array($request->input('sort'))) {
            foreach($request->input('sort') as $key => $value)
            {
                $sort_column = $key;
                $sort_type = $value;
            }
        }

        $data = array();
        $data['current'] = intval($current);
        $data['rowCount'] = $rowCount;
        $data['searchPhrase'] = $this->searchPhrase;
        $data['rows'] = Menu::join('modules','modules.module_id','=','menus.module_id')
                            ->where('menus.active','1')
                            ->where(function($query) {
                                $query->where('menu_name','like','%' . $this->searchPhrase . '%')
                                        ->orWhere('module_url','like','%' . $this->searchPhrase . '%')
                                        ->orWhere('menu_desc','like','%' . $this->searchPhrase . '%')
                                        ->orWhere('menu_order','like','%' . $this->searchPhrase . '%')
                                        ->orWhere('menu_parent','like','%' . $this->searchPhrase . '%');
                            })
                            ->skip($skip)->take($rowCount)
                            ->orderBy($sort_column, $sort_type)->get();
        $data['total'] = Menu::join('modules','modules.module_id','=','menus.module_id')
                                ->where('menus.active','1')
                                ->where(function($query) {
                                    $query->where('menu_name','like','%' . $this->searchPhrase . '%')
                                        ->orWhere('module_url','like','%' . $this->searchPhrase . '%')
                                        ->orWhere('menu_desc','like','%' . $this->searchPhrase . '%')
                                        ->orWhere('menu_order','like','%' . $this->searchPhrase . '%')
                                        ->orWhere('menu_parent','like','%' . $this->searchPhrase . '%');
                                })->count();

        return response()->json($data);
    }


    public function apiDelete(Request $request)
    {
        $id = $request->input('menu_id');

        $obj = Menu::find($id);

        //reorder menu
        $this->reorderMenu($request, 'DELETE', $obj->menu_parent, $obj->menu_order);

        $obj->active = '0';
        $obj->updated_by = $request->user()->user_id;

        if($obj->save())
        {
            return response()->json(100); //success
        }else{
            return response()->json(200); //failed
        }
    }

    /**
    * 
    * @param int parent_id
    *
    * @return json
    *
    **/
    public function apiCountChild(Request $request)
    {
        $result = array();

        /*if(!$request->input('parent_id'))
            return;*/

        //$parent = Menu::find($request->input('parent_id'));
        $result['count'] = Menu::where('active', '1')->where('menu_parent', $request->input('parent_id'))->count();

        return response()->json($result);
    }

    /**
    *
    * @param int $default
    *
    * @return array
    **/
    private function generateParentOption()
    {
        $data = Menu::where('active','1')->orderBy('menu_order','asc')->get();
        $recursive = new Recursive;
        $tmp = $recursive->data_recursive($data, 'menu_id', 'menu_parent', 0);
        $options = $recursive->option_recursive($tmp,'menu_id','menu_name',NULL,[],0);
        return $options;   
    }

    public function generateMenu()
    {
        $data = Menu::where('active','1')->orderBy('menu_order','asc')->get();
        $recursive = new Recursive;
        $tmp = $recursive->data_recursive($data, 'menu_id', 'menu_parent', 0);
        $options = $recursive->option_recursive($tmp,'menu_id','menu_name',NULL,[],0);
        dd($options);
    }

    /**
    * 
    * @param string $method (ADD, UPDATE, DELETE)
    * @param int $parent_id
    * @param int $order
    *
    * @return void()
    **/
    private function reorderMenu(Request $request, $method, $parent_id, $order, $direction = NULL, $old_order = NULL)
    {
        if($method == 'ADD')
        {
            $menus = Menu::where('active','1')->where('menu_parent', $parent_id)->where('menu_order', '>=', $order)->get();

            foreach($menus as $menu)
            {
                $update = Menu::find($menu->menu_id);
                $update->menu_order = $menu->menu_order + 1;
                $update->updated_by = $request->user()->user_id;
                $update->save();
            }
        }elseif($method == 'UPDATE'){
            if($direction == 'TOLOWER')
            {
                $menus = Menu::where('active','1')->where('menu_parent', $parent_id)->where('menu_order', '>=', $order)->where('menu_order', '<=', $old_order)->get();

                foreach($menus as $menu)
                {
                    $update = Menu::find($menu->menu_id);
                    $update->menu_order = $menu->menu_order + 1;
                    $update->updated_by = $request->user()->user_id;
                    $update->save();
                }
            }
            elseif($direction == 'TOUPPER')
            {
                $menus = Menu::where('active','1')->where('menu_parent', $parent_id)->where('menu_order', '<=', $order)->where('menu_order', '>=', $old_order)->get();

                foreach($menus as $menu)
                {
                    $update = Menu::find($menu->menu_id);
                    $update->menu_order = $menu->menu_order - 1;
                    $update->updated_by = $request->user()->user_id;
                    $update->save();
                }
            }
        }elseif($method == 'DELETE'){
            $menus = Menu::where('active','1')->where('menu_parent', $parent_id)->where('menu_order', '>', $order)->get();

            foreach($menus as $menu)
            {
                $update = Menu::find($menu->menu_id);
                $update->menu_order = $menu->menu_order - 1;
                $update->updated_by = $request->user()->user_id;
                $update->save();
            }
        }
    }
}
