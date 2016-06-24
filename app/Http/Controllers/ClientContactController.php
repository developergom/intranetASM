<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;

use App\Http\Requests;
use App\Client;
use App\ClientContact;
use App\Religion;

class ClientContactController extends Controller
{
    public function apiSave(Request $request)
    {
        $this->validate($request, [
            'client_id' => 'required',
            'client_contact_name' => 'required|max:100',
            'client_contact_gender' => 'required|numeric',
            'religion_id' => 'required',
            'client_contact_email' => 'required|max:255|unique:client_contacts,client_contact_email',
            'client_contact_phone' => 'required|max:15|unique:client_contacts,client_contact_phone',
            'client_contact_position' => 'required|max:100',
        ]);

        $obj = new ClientContact;

        $obj->client_id = $request->input('client_id');
        $obj->client_contact_name = $request->input('client_contact_name');
        $obj->client_contact_gender = $request->input('client_contact_gender');
        $obj->client_contact_birthdate = Carbon::createFromFormat('d/m/Y', $request->input('client_contact_birthdate'))->toDateString();
        $obj->religion_id = $request->input('religion_id');
        $obj->client_contact_phone = $request->input('client_contact_phone');
        $obj->client_contact_email = $request->input('client_contact_email');
        $obj->client_contact_position = $request->input('client_contact_position');
        $obj->active = '1';
        $obj->created_by = $request->user()->user_id;

        if($obj->save())
        {
            return response()->json(100); //success
        }else{
            $data = validation_errors();
            return response()->json($data); //failed
        }
    }

    public function apiList(Request $request)
    {
        $id = $request->input('id');

        $current = $request->input('current') or 1;
        $rowCount = $request->input('rowCount') or 5;
        $skip = ($current==1) ? 0 : (($current - 1) * $rowCount);
        $searchPhrase = $request->input('searchPhrase') or '';
        
        $sort_column = 'client_contact_id';
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
        $data['rows'] = ClientContact::join('religions','religions.religion_id','=','client_contacts.religion_id')
                            ->where('client_contacts.active','1')
                            ->where('client_contacts.client_id',$id)
                            ->where(function($query) use($searchPhrase) {
                                $query->where('client_contact_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('client_contact_position','like','%' . $searchPhrase . '%')
                                        ->orWhere('client_contact_email','like','%' . $searchPhrase . '%')
                                        ->orWhere('client_contact_phone','like','%' . $searchPhrase . '%');
                            })
                            ->skip($skip)->take($rowCount)
                            ->orderBy($sort_column, $sort_type)->get();
        $data['total'] = ClientContact::join('religions','religions.religion_id','=','client_contacts.religion_id')
                            ->where('client_contacts.active','1')
                            ->where('client_contacts.client_id',$id)
                            ->where(function($query) use($searchPhrase) {
                                $query->where('client_contact_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('client_contact_position','like','%' . $searchPhrase . '%')
                                        ->orWhere('client_contact_email','like','%' . $searchPhrase . '%')
                                        ->orWhere('client_contact_phone','like','%' . $searchPhrase . '%');
                            })->count();

        return response()->json($data);
    }


    public function apiEdit(Request $request)
    {
        $id = $request->input('client_contact_id');

        $obj = ClientContact::find($id);

        $obj->client_id = $request->input('client_id');
        $obj->client_contact_name = $request->input('client_contact_name');
        $obj->client_contact_gender = $request->input('client_contact_gender');
        $obj->client_contact_birthdate = Carbon::createFromFormat('d/m/Y', $request->input('client_contact_birthdate'))->toDateString();
        $obj->religion_id = $request->input('religion_id');
        $obj->client_contact_phone = $request->input('client_contact_phone');
        $obj->client_contact_email = $request->input('client_contact_email');
        $obj->client_contact_position = $request->input('client_contact_position');
        $obj->updated_by = $request->user()->user_id;

        if($obj->save())
        {
            return response()->json(100); //success
        }else{
            return response()->json(200); //failed
        }   
    }


    public function apiDelete(Request $request)
    {
        $id = $request->input('client_contact_id');

        $obj = ClientContact::find($id);

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
