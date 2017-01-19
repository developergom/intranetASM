<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    protected $table = 'proposals';
	protected $primaryKey = 'proposal_id';

	protected $fillable = [
				'proposal_type_id', 
				'proposal_name',
				'proposal_deadline',
				'proposal_desc',
				'proposal_no',
				'proposal_status_id',
				'proposal_method_id',
				'proposal_ready_date',
				'proposal_delivery_date',
				'client_id',
				'brand_id',
				'pic',
				'flow_no',
				'revision_no',
				'current_user',
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function agendas()
	{
		return $this->belongsToMany('App\Agenda', 'agendas_proposals');
	}

	public function activities()
	{
		return $this->belongsToMany('App\Activity', 'activities_proposals');
	}

	public function proposaltype()
	{
		return $this->belongsTo('App\ProposalType', 'proposal_type_id');
	}

	public function proposalstatus()
	{
		return $this->belongsTo('App\ProposalStatus', 'proposal_status_id');
	}

	public function proposalmethod()
	{
		return $this->belongsTo('App\ProposalMethod', 'proposal_method_id');
	}

	public function medias() 
	{
		return $this->belongsToMany('App\Media', 'proposal_media');
	}

	public function client_contacts()
	{
		return $this->belongsToMany('App\ClientContact', 'proposal_client_contact');
	}

	public function industries() 
	{
		return $this->belongsToMany('App\Industry', 'proposal_industry');
	}

	public function uploadfiles()
	{
		return $this->belongsToMany('App\UploadFile', 'proposal_upload_file');
	}

	public function inventoriesplanner()
	{
		return $this->belongsToMany('App\InventoryPlanner', 'proposal_inventory_planner');
	}

	public function proposalprintprices()
	{
		return $this->hasMany('App\ProposalPrintPrice', 'proposal_id');
	}

	public function proposaldigitalprices()
	{
		return $this->hasMany('App\ProposalDigitalPrice', 'proposal_id');
	}

	public function proposaleventprices()
	{
		return $this->hasMany('App\ProposalEventPrice', 'proposal_id');
	}

	public function proposalcreativeprices()
	{
		return $this->hasMany('App\ProposalCreativePrice', 'proposal_id');
	}

	public function proposalotherprices()
	{
		return $this->hasMany('App\ProposalOtherPrice', 'proposal_id');
	}

	public function proposalhistories()
	{
		return $this->hasMany('App\ProposalHistory', 'proposal_id');
	}

	public function getCreatedByAttribute($value)
	{
		$user = User::find($value); 
		return $user;
	}

	public function getUpdatedByAttribute($value)
	{
		$user = User::find($value); 
		return $user;
	}
}
