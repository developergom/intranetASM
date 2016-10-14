<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CreativeHistory extends Model
{
    protected $table = 'creative_histories';
	protected $primaryKey = 'creative_history_id';

	protected $fillable = [
				'creative_id', 
				'approval_type_id', 
				'creative_history_text'
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function creative() 
	{
		return $this->belongsTo('App\Creative', 'creative_id');
	}

	public function approvaltype()
	{
		return $this->belongsTo('App\ApprovalType', 'approval_type_id');	
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
