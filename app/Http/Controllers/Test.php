<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Excel;
use App\AdvertisePosition;
use App\Brand;
use App\ClientContact;
use App\Client;
use App\CreativeFormat;
use App\Industry;
use App\InventoryType;
use App\MediaCategory;
use App\MediaGroup;
use App\Paper;
use App\ProposalType;
use App\SubIndustry;
use App\User;
use Auth;

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

	public function import_data($table) 
	{
		if($table == 'advertise_positions') {
			Excel::selectSheets('advertise_positions')->load('Master Data Intranet ASM 2017.xls', function($reader) {
				$result = $reader->all();

				$items = $result->all();

				$i = 0;
				foreach ($items as $item) {
					$row = $item->toArray();
					
					$data = new AdvertisePosition;
					$data->advertise_position_name = $row['advertise_position_name'];
					$data->advertise_position_desc = $row['advertise_position_desc'];
					$data->active = '1';
					$data->created_by = '1';

					$data->save();
					$i++;
				}

				echo $i . ' rows has been saved...';
			});
		}elseif($table == 'creative_formats') {
			Excel::selectSheets('creative_formats')->load('Master Data Intranet ASM 2017.xls', function($reader) {
				$result = $reader->all();

				$items = $result->all();

				$i = 0;
				foreach ($items as $item) {
					$row = $item->toArray();
					
					$data = new CreativeFormat;
					$data->creative_format_name = $row['creative_format_name'];
					$data->creative_format_desc = (is_null($row['creative_format_desc'])) ? '' : $row['creative_format_desc'];
					$data->active = '1';
					$data->created_by = '1';

					$data->save();
					$i++;
				}

				echo $i . ' rows has been saved...';
			});	
		}elseif($table == 'industries') {
			Excel::selectSheets('industries')->load('Master Data Intranet ASM 2017.xls', function($reader) {
				$result = $reader->all();

				$items = $result->all();

				$i = 0;
				foreach ($items as $item) {
					$row = $item->toArray();
					
					$data = new Industry;
					$data->industry_code = $row['industry_code'];
					$data->industry_name = $row['industry_name'];
					$data->industry_desc = (is_null($row['industry_desc'])) ? '' : $row['industry_desc'];
					$data->active = '1';
					$data->created_by = '1';

					$data->save();
					$i++;
				}

				echo $i . ' rows has been saved...';
			});
		}elseif($table == 'media_categories') {
			Excel::selectSheets('media_categories')->load('Master Data Intranet ASM 2017.xls', function($reader) {
				$result = $reader->all();

				$items = $result->all();

				$i = 0;
				foreach ($items as $item) {
					$row = $item->toArray();
					
					$data = new MediaCategory;
					$data->media_category_name = $row['media_category_name'];
					$data->media_category_desc = (is_null($row['media_category_desc'])) ? '' : $row['media_category_desc'];
					$data->active = '1';
					$data->created_by = '1';

					$data->save();
					$i++;
				}

				echo $i . ' rows has been saved...';
			});
		}elseif($table == 'media_groups') {
			Excel::selectSheets('media_groups')->load('Master Data Intranet ASM 2017.xls', function($reader) {
				$result = $reader->all();

				$items = $result->all();

				$i = 0;
				foreach ($items as $item) {
					$row = $item->toArray();
					
					$data = new MediaGroup;
					$data->publisher_id = $row['publisher_id'];
					$data->media_group_code = $row['media_group_code'];
					$data->media_group_name = $row['media_group_name'];
					$data->media_group_desc = (is_null($row['media_group_desc'])) ? '' : $row['media_group_desc'];
					$data->active = '1';
					$data->created_by = '1';

					$data->save();
					$i++;
				}

				echo $i . ' rows has been saved...';
			});
		}elseif($table == 'papers') {
			Excel::selectSheets('papers')->load('Master Data Intranet ASM 2017.xls', function($reader) {
				$result = $reader->all();

				$items = $result->all();

				$i = 0;
				foreach ($items as $item) {
					$row = $item->toArray();
					
					$data = new Paper;
					$data->unit_id = $row['unit_id'];
					$data->paper_name = $row['paper_name'];
					$data->paper_width = 0;
					$data->paper_length = 0;
					$data->paper_desc = (is_null($row['paper_desc'])) ? '' : $row['paper_desc'];
					$data->active = '1';
					$data->created_by = '1';

					$data->save();
					$i++;
				}

				echo $i . ' rows has been saved...';
			});
		}elseif($table == 'subindustries') {
			Excel::selectSheets('subindustries')->load('Master Data Intranet ASM 2017.xls', function($reader) {
				$result = $reader->all();

				$items = $result->all();

				$i = 0;
				foreach ($items as $item) {
					$row = $item->toArray();
					
					$data = new SubIndustry;
					$data->subindustry_code = $row['subindustry_code'];
					$data->industry_id = $row['industry_id'];
					$data->subindustry_name = $row['subindustry_name'];
					$data->subindustry_desc = (is_null($row['subindustry_desc'])) ? '' : $row['subindustry_desc'];
					$data->active = '1';
					$data->created_by = '1';

					$data->save();
					$i++;
				}

				echo $i . ' rows has been saved...';
			});
		}elseif($table == 'units') {
			Excel::selectSheets('units')->load('Master Data Intranet ASM 2017.xls', function($reader) {
				$result = $reader->all();

				$items = $result->all();

				dd($items);
			});
		}elseif($table == 'medias') {
			Excel::selectSheets('medias')->load('Master Data Intranet ASM 2017.xls', function($reader) {
				$result = $reader->all();

				$items = $result->all();

				dd($items);
			});
		}elseif($table == 'advertise_sizes') {
			Excel::selectSheets('advertise_sizes')->load('Master Data Intranet ASM 2017.xls', function($reader) {
				$result = $reader->all();

				$items = $result->all();

				dd($items);
			});
		}elseif($table == 'proposal_types') {
			Excel::selectSheets('proposal_types')->load('Master Data Intranet ASM 2017.xls', function($reader) {
				$result = $reader->all();

				$items = $result->all();

				$i = 0;
				foreach ($items as $item) {
					$row = $item->toArray();
					
					$data = new ProposalType;
					$data->proposal_type_name = $row['proposal_type_name'];
					$data->proposal_type_duration = $row['proposal_type_duration'];
					$data->proposal_type_desc = (is_null($row['proposal_type_desc'])) ? '' : $row['proposal_type_desc'];
					$data->active = '1';
					$data->created_by = '1';

					$data->save();
					$i++;
				}

				echo $i . ' rows has been saved...';
			});
		}elseif($table == 'inventory_types') {
			Excel::selectSheets('inventory_types')->load('Master Data Intranet ASM 2017.xls', function($reader) {
				$result = $reader->all();

				$items = $result->all();

				$i = 0;
				foreach ($items as $item) {
					$row = $item->toArray();
					
					$data = new InventoryType;
					$data->inventory_type_name = $row['inventory_type_name'];
					$data->inventory_type_duration = $row['inventory_type_duration'];
					$data->inventory_type_desc = (is_null($row['inventory_type_desc'])) ? '' : $row['inventory_type_desc'];
					$data->active = '1';
					$data->created_by = '1';

					$data->save();
					$i++;
				}

				echo $i . ' rows has been saved...';
			});
		}elseif($table == 'media_editions') {
			Excel::selectSheets('media_editions')->load('Master Data Intranet ASM 2017.xls', function($reader) {
				$result = $reader->all();

				$items = $result->all();

				dd($items);
			});
		}elseif($table == 'brands') {
			Excel::selectSheets('Sheet1')->load('MasterBrand.xlsx', function($reader) {
				$result = $reader->all();

				$items = $result->all();

				//dd($items);

				$i = 0;
				foreach ($items as $item) {
					$row = $item->toArray();

					//dd($row);
					
					$data = new Brand;
					$data->subindustry_id = intval($row['brandsubindustryid']);
					$data->brand_code = intval($row['brandindustryid']) . '000' . intval($row['brandsubindustryid']) . '00' . $i;
					$data->brand_name = $row['brandname'];
					$data->brand_desc = $row['brandname'];
					$data->active = '1';
					$data->created_by = '1';

					$data->save();
					$i++;
				}

				echo $i . ' rows has been saved...';
			});
		}

	}

	public function handsontable(){
		return view('vendor.material.test_handsontable');
	}

	public function apiTest(){
		return response()->json(
 
           User::where('user_id',Auth::guard('api')->id())->get()
 
       );
	}

}