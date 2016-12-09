<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Excel;
use App\ClientContact;
use App\Client;

class Test extends Controller{
	public function __construct() {

	}

	public function index() {
		/*Excel::load('Data Client.xls', function($reader) {

		    // Getting all results
		    //$results = $reader->get();

		    // ->all() is a wrapper for ->get() and will work the same
		    //$results = $reader->all();

		    $results = $reader->selectSheets('Sheet1')->load();


		    dd($results);
		});*/

		Excel::selectSheets('Sheet1')->load('Data Client.xls', function($reader) {
			$result = $reader->all();

			$items = $result->all();

			foreach($items as $item) {
				$row = $item->toArray();
				//dd($row);

				if(!ClientContact::find($row['contactid'])) {
					//belum ada
					//dd('belumada');

					$randomphone = substr(md5(microtime()), rand(0,26), 12);
					$randomemail = substr(md5(microtime()), rand(0,26), 12);

					$contact = new ClientContact;

					$contact->client_contact_id = $row['contactid'];
					$contact->client_id = $row['clientid'];
					$contact->client_contact_name = $row['contactname'];
					$contact->client_contact_gender = '1';
					$contact->client_contact_birthdate = (($row['dob'] == 'NULL') || ($row['dob'] == '')) ? '1990-01-01' : $row['dob']->format('Y-m-d');
					$contact->religion_id = '7';
					$contact->client_contact_phone = (($row['cellular'] == 'NULL')  || ($row['cellular'] == '')) ? $randomphone : $row['cellular'];
					$contact->client_contact_email = (($row['email'] == 'NULL')  || ($row['email'] == '')) ? $randomemail  : $row['email'];
					$contact->client_contact_position = (($row['contactposition'] == 'NULL')  || ($row['contactposition'] == '')) ? 'Unknown' : $row['contactposition'];
					$contact->active = '1';
					$contact->created_by = '1';

					$contact->save();
				}else{	
					//sudah ada
					//dd('sudahada');
				}


				/*if(!Client::find($row['clientid'])) {
					//belum ada
					//dd('belumada');

					$randomphone = substr(md5(microtime()), rand(0,26), 12);
					$randomfax = substr(md5(microtime()), rand(0,26), 12);
					$randomemail = substr(md5(microtime()), rand(0,26), 12);

					$client = new Client;

					$client->client_id = $row['clientid'];
					$client->client_type_id = $row['clienttypeid'];
					$client->client_name = $row['clientname'];
					$client->client_formal_name = $row['formalname'];
					$client->client_mail_address = $row['mailaddress'];
					$client->client_mail_postcode = (($row['mailpostcode'] == 'NULL') || ($row['mailpostcode'] == '')) ? '10000' : $row['mailpostcode'];
					$client->client_npwp = '';
					$client->client_npwp_address = $row['npwpaddress'];
					$client->client_npwp_postcode = (($row['npwppostcode'] == 'NULL') || ($row['npwppostcode'] == '')) ? '10000' : $row['npwppostcode'];
					$client->client_invoice_address = $row['invoiceaddress'];
					$client->client_invoice_postcode = (($row['invoicepostcode'] == 'NULL') || ($row['invoicepostcode'] == '')) ? '10000' : $row['invoicepostcode'];
					$client->client_phone = $row['phone'];
					$client->client_fax = $row['fax'];
					$client->client_email = $randomemail;
					$client->client_avatar = 'logo.jpg';
					$client->active = '1';
					$client->created_by = '1';

					$client->save();
				}else{	
					//sudah ada
					//dd('sudahada');
				}*/
			}

			//dd($items);
		});
	
	}

}