<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GridProposal extends Model
{
    protected $table = 'grid_proposals';
	protected $primaryKey = 'grid_proposal_id';

	protected $fillable = [
				'grid_proposal_name',
				'grid_proposal_deadline',
				'grid_proposal_desc',
				'grid_proposal_no',
				'grid_proposal_ready_date',
				'grid_proposal_delivery_date',
				'approval_1',
				'pic_1',
				'pic_2',
				'flow_no',
				'revision_no',
				'current_user',
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function gridproposalhistories()
	{
		return $this->hasMany('App\GridProposalHistory', 'grid_proposal_id');
	}

	public function uploadfiles()
	{
		return $this->belongsToMany('App\UploadFile', 'grid_proposal_upload_file');
	}

	public function _currentuser()
	{
		return $this->belongsTo('App\User', 'current_user');
	}

	public function _approval_1()
	{
		return $this->belongsTo('App\User', 'approval_1');	
	}

	public function _pic_1()
	{
		return $this->belongsTo('App\User', 'pic_1');	
	}

	public function _pic_2()
	{
		return $this->belongsTo('App\User', 'pic_2');	
	}

	public function _created_by()
	{
		return $this->belongsTo('App\User', 'created_by');
	}
}
