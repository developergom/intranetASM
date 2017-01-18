<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientContact extends Model
{
    protected $table = 'client_contacts';
	protected $primaryKey = 'client_contact_id';

	protected $fillable = [
				'client_id', 
				'client_contact_name', 
				'client_contact_gender', 
				'client_contact_birthdate',
				'religion_id',
				'client_npwp',
				'client_contact_phone',
				'client_contact_email',
				'client_contact_position',
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function client()
	{
		return $this->belongsTo('App\Client', 'client_id');
	}

	public function religion()
	{
		return $this->belongsTo('App\Religion', 'religion_id');
	}

	public function agendas() {
		return $this->belongsToMany('App\Agenda', 'agendas_clients');
	}

	public function activities() {
		return $this->belongsToMany('App\Activity', 'activities_clients');
	}

	public function proposals()
	{
		return $this->belongsToMany('App\Proposal', 'proposal_client_contact');
	}
}
