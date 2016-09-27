<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    protected $table = 'agendas';
	protected $primaryKey = 'agenda_id';

	protected $fillable = [
				'agenda_type_id', 'agenda_date', 'agenda_destination', 'agenda_desc'
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function agendatype() {
		return $this->belongsTo('App\AgendaType', 'agenda_type_id');
	}

	public function clients() {
		return $this->belongsToMany('App\Client', 'agendas_clients');
	}

	public function clientcontacts() {
		return $this->belongsToMany('App\ClientContact', 'agendas_client_contacts');
	}

	public function users() {
		return $this->belongsToMany('App\User', 'agendas_users');
	}
}
