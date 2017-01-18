<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'clients';
	protected $primaryKey = 'client_id';

	protected $fillable = [
				'client_type_id', 
				'client_name', 
				'client_formal_name', 
				'client_mail_address',
				'client_mail_postcode',
				'client_npwp',
				'client_npwp_address',
				'client_npwp_postcode',
				'client_invoice_address',
				'client_invoice_postcode',
				'client_phone',
				'client_fax',
				'client_email',
				'client_avatar'
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function clienttype()
	{
		return $this->belongsTo('App\ClientType', 'client_type_id');
	}

	public function clientcontact()
	{
		return $this->hasMany('App\ClientContact', 'client_contact_id');
	}

	public function agendas() {
		return $this->belongsToMany('App\Agenda', 'agendas_clients');
	}

	public function activities() {
		return $this->belongsToMany('App\Activity', 'activities_clients');
	}
}
