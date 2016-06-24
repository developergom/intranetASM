<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;

use App\Http\Requests;
use App\Client;
use App\ClientType;
use App\Religion;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('vendor.material.master.client.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array();
        $data['clienttype'] = ClientType::where('active', '1')->orderBy('client_type_name')->get();
        return view('vendor.material.master.client.create', $data);
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
            'client_type_id' => 'required',
            'client_name' => 'required|max:255',
            'client_formal_name' => 'required|max:255',
            'client_mail_address' => 'required',
            'client_mail_postcode' => 'required|max:10',
            'client_npwp' => 'required|max:25',
            'client_npwp_address' => 'required',
            'client_npwp_postcode' => 'required|max:10',
            'client_invoice_address' => 'required',
            'client_invoice_postcode' => 'required|max:10',
            'client_phone' => 'required|max:15',
            'client_email' => 'required|max:255',
            'client_avatar' => 'image|max:2000',
        ]);

        if ($request->hasFile('client_avatar')) {
            if ($request->file('client_avatar')->isValid()) {
                $uploaded = $request->file('client_avatar');
                $client_avatar = Carbon::now()->format('YmdHis') . $uploaded->getClientOriginalName();
                $uploaded->move(
                    base_path() . '/public/img/client/logo/', $client_avatar
                );
            }else{
                $client_avatar = 'logo.jpg';    
            }
        }else{
            $client_avatar = 'logo.jpg';
        }

        $obj = new Client;

        $obj->client_type_id = $request->input('client_type_id');
        $obj->client_name = $request->input('client_name');
        $obj->client_formal_name = $request->input('client_formal_name');
        $obj->client_mail_address = $request->input('client_mail_address');
        $obj->client_mail_postcode = $request->input('client_mail_postcode');
        $obj->client_npwp = $request->input('client_npwp');
        $obj->client_npwp_address = $request->input('client_npwp_address');
        $obj->client_npwp_postcode = $request->input('client_npwp_postcode');
        $obj->client_invoice_address = $request->input('client_invoice_address');
        $obj->client_invoice_postcode = $request->input('client_invoice_postcode');
        $obj->client_phone = $request->input('client_phone');
        $obj->client_fax = $request->input('client_fax');
        $obj->client_email = $request->input('client_email');
        $obj->client_avatar = $client_avatar;
        $obj->active = '1';
        $obj->created_by = $request->user()->user_id;

        $obj->save();

        $request->session()->flash('status', 'Data has been saved!');

        return redirect('master/client');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = array();
        $data['client'] = Client::where('active','1')->find($id);
        $data['religion'] = Religion::where('active', '1')->orderBy('religion_name')->get();
        return view('vendor.material.master.client.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = array();
        $data['clienttype'] = ClientType::where('active', '1')->orderBy('client_type_name')->get();
        $data['client'] = Client::where('active','1')->find($id);
        return view('vendor.material.master.client.edit', $data);
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
            'client_type_id' => 'required',
            'client_name' => 'required|max:255',
            'client_formal_name' => 'required|max:255',
            'client_mail_address' => 'required',
            'client_mail_postcode' => 'required|max:10',
            'client_npwp' => 'required|max:25',
            'client_npwp_address' => 'required',
            'client_npwp_postcode' => 'required|max:10',
            'client_invoice_address' => 'required',
            'client_invoice_postcode' => 'required|max:10',
            'client_phone' => 'required|max:15',
            'client_email' => 'required|max:255',
            'client_avatar' => 'image|max:2000',
        ]);

        $obj = Client::find($id);

        $obj->client_type_id = $request->input('client_type_id');
        $obj->client_name = $request->input('client_name');
        $obj->client_formal_name = $request->input('client_formal_name');
        $obj->client_mail_address = $request->input('client_mail_address');
        $obj->client_mail_postcode = $request->input('client_mail_postcode');
        $obj->client_npwp = $request->input('client_npwp');
        $obj->client_npwp_address = $request->input('client_npwp_address');
        $obj->client_npwp_postcode = $request->input('client_npwp_postcode');
        $obj->client_invoice_address = $request->input('client_invoice_address');
        $obj->client_invoice_postcode = $request->input('client_invoice_postcode');
        $obj->client_phone = $request->input('client_phone');
        $obj->client_fax = $request->input('client_fax');
        $obj->client_email = $request->input('client_email');
        $obj->updated_by = $request->user()->user_id;

        if ($request->hasFile('client_avatar')) {
            if ($request->file('client_avatar')->isValid()) {
                $uploaded = $request->file('client_avatar');
                $client_avatar = Carbon::now()->format('YmdHis') . $uploaded->getClientOriginalName();
                $uploaded->move(
                    base_path() . '/public/img/client/logo/', $client_avatar
                );

                $obj->client_avatar = $client_avatar;

            }
        }

        $obj->save();

        $request->session()->flash('status', 'Data has been updated!');

        return redirect('master/client');
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
        $searchPhrase = $request->input('searchPhrase') or '';
        
        $sort_column = 'client_id';
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
        $data['rows'] = Client::join('client_types','client_types.client_type_id', '=', 'clients.client_type_id')
                            ->where('clients.active','1')
                            ->where(function($query) use($searchPhrase) {
                                $query->orWhere('client_type_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('client_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('client_formal_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('client_email','like','%' . $searchPhrase . '%')
                                        ->orWhere('client_phone','like','%' . $searchPhrase . '%');
                            })
                            ->skip($skip)->take($rowCount)
                            ->orderBy($sort_column, $sort_type)->get();
        $data['total'] = Client::join('client_types','client_types.client_type_id', '=', 'clients.client_type_id')
                            ->where('clients.active','1')
                            ->where(function($query) use($searchPhrase) {
                                $query->orWhere('client_type_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('client_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('client_formal_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('client_email','like','%' . $searchPhrase . '%')
                                        ->orWhere('client_phone','like','%' . $searchPhrase . '%');
                            })->count();

        return response()->json($data);
    }


    public function apiDelete(Request $request)
    {
        $id = $request->input('client_id');

        $obj = Client::find($id);

        $obj->active = '0';
        $obj->updated_by = $request->user()->user_id;

        if($obj->save())
        {
            return response()->json(100); //success
        }else{
            return response()->json(200); //failed
        }
    }
}
