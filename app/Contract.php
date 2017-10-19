<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $table = 'contracts';
	protected $primaryKey = 'contract_id';

	protected $fillable = [
				'proposal_id', 
				'contract_no',
				'contract_date',
				'contract_notes',
				'revision_no',
				'current_user',
				'flow_no',
				'pic',
				'updated_at',
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by'
	];

	public function proposal()
	{
		return $this->belongsTo('App\Proposal', 'proposal_id');
	}

	public function summary()
	{
		return $this->hasOne('App\Contract', 'contract_id');
	}

	public function contracthistories()
	{
		return $this->hasMany('App\ContractHistory', 'contract_id');
	}

	public function uploadfiles()
	{
		return $this->belongsToMany('App\UploadFile', 'contract_upload_file');
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

	public function _currentuser()
	{
		return $this->belongsTo('App\User', 'current_user');
	}

	public function _pic()
	{
		return $this->belongsTo('App\User', 'pic');
	}
}
