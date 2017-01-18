<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table = 'activities';
	protected $primaryKey = 'activity_id';

	protected $fillable = [
				'activity_type_id', 'activity_status', 'activity_date', 'activity_destination', 'activity_desc'
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function activitytype() {
		return $this->belongsTo('App\ActivityType', 'activity_type_id');
	}

	public function agendas() {
		return $this->belongsToMany('App\Agenda', 'activities_agendas');
	}

	public function clients() {
		return $this->belongsToMany('App\Client', 'activities_clients');
	}

	public function clientcontacts() {
		return $this->belongsToMany('App\ClientContact', 'activities_client_contacts');
	}

	public function users() {
		return $this->belongsToMany('App\User', 'activities_users');
	}

	public function inventories()
	{
		return $this->belongsToMany('App\InventoryPlanner', 'activities_inventories');
	}

	public function proposals()
	{
		return $this->belongsToMany('App\Proposal', 'activities_proposals');
	}
}
