<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Gate;
use App\Http\Requests;
use App\Brand;
use App\Industry;
use App\SubIndustry;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::denies('Brands Management-Read')) {
            abort(403, 'Unauthorized action.');
        }

        return view('vendor.material.master.brand.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Gate::denies('Brands Management-Create')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();
        $data['industry'] = Industry::where('active','1')->orderBy('industry_code')->get();
        $data['subindustry'] = SubIndustry::where('active','1')->orderBy('subindustry_code')->get();
        return view('vendor.material.master.brand.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'subindustry_id' => 'required',
            'brand_code' => 'required|max:15|unique:brands,brand_code',
            'brand_name' => 'required|max:100'
        ]);

        $obj = new Brand;

        $obj->subindustry_id = $request->input('subindustry_id');
        $obj->brand_code = $request->input('brand_code');
        $obj->brand_name = $request->input('brand_name');
        $obj->brand_desc = $request->input('brand_desc');
        $obj->active = '1';
        $obj->created_by = $request->user()->user_id;

        $obj->save();

        $request->session()->flash('status', 'Data has been saved!');

        return redirect('master/brand');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Gate::denies('Brands Management-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();
        $data['brand'] = Brand::where('active','1')->find($id);
        return view('vendor.material.master.brand.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Gate::denies('Brands Management-Update')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();
        $data['industry'] = Industry::where('active','1')->orderBy('industry_code')->get();
        $data['brand'] = Brand::where('active','1')->find($id);
        $data['subindustry'] = SubIndustry::where('active','1')->where('industry_id', $data['brand']->subindustry->industry_id)->orderBy('subindustry_code')->get();
        return view('vendor.material.master.brand.edit', $data);
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
        $this->validate($request, [
            'subindustry_id' => 'required',
            'brand_code' => 'required|max:15|unique:brands,brand_code,'.$id.',brand_id',
            'brand_name' => 'required|max:100',
        ]);

        $obj = Brand::find($id);

        $obj->subindustry_id = $request->input('subindustry_id');
        $obj->brand_code = $request->input('brand_code');
        $obj->brand_name = $request->input('brand_name');
        $obj->brand_desc = $request->input('brand_desc');
        $obj->updated_by = $request->user()->user_id;

        $obj->save();

        $request->session()->flash('status', 'Data has been updated!');

        return redirect('master/brand');
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
        $rowCount = $request->input('rowCount') or 10;
        $skip = ($current==1) ? 0 : (($current - 1) * $rowCount);
        $searchPhrase = $request->input('searchPhrase') or '';
        
        $sort_column = 'brand_id';
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
        $data['searchPhrase'] = $searchPhrase;
        $data['rows'] = Brand::join('subindustries','subindustries.subindustry_id', '=', 'brands.subindustry_id')
                            ->join('industries','industries.industry_id', '=', 'subindustries.industry_id')
                            ->where('brands.active','1')
                            ->where(function($query) use($searchPhrase) {
                                $query->where('industry_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('subindustry_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('brand_code','like','%' . $searchPhrase . '%')
                                        ->orWhere('brand_name','like','%' . $searchPhrase . '%');
                            })
                            ->skip($skip)->take($rowCount)
                            ->orderBy($sort_column, $sort_type)->get();
        $data['total'] = Brand::join('subindustries','subindustries.subindustry_id', '=', 'brands.subindustry_id')
                            ->join('industries','industries.industry_id', '=', 'subindustries.industry_id')
                            ->where('brands.active','1')
                            ->where(function($query) use($searchPhrase) {
                                $query->where('industry_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('subindustry_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('brand_code','like','%' . $searchPhrase . '%')
                                        ->orWhere('brand_name','like','%' . $searchPhrase . '%');
                            })->count();

        return response()->json($data);
    }


    public function apiDelete(Request $request)
    {
        if(Gate::denies('Brands Management-Delete')) {
            abort(403, 'Unauthorized action.');
        }

        $id = $request->input('brand_id');

        $obj = Brand::find($id);

        $obj->active = '0';
        $obj->updated_by = $request->user()->user_id;

        if($obj->save())
        {
            return response()->json(100); //success
        }else{
            return response()->json(200); //failed
        }
    }

    public function apiSearch(Request $request)
    {
        if(Gate::denies('Home-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $brand_name = $request->brand_name;

        $result = Brand::where('brand_name','like','%' . $brand_name . '%')->where('active', '1')->take(5)->orderBy('brand_name')->get();

        return response()->json($result, 200);
    }
}
