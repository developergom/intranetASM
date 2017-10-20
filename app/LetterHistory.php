<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LetterHistory extends Model
{
    protected $table = 'letter_histories';
	protected $primaryKey = 'letter_history_id';

	protected $fillable = [
				'letter_id', 
				'approval_type_id', 
				'letter_history_text'
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function letter() 
	{
		return $this->belongsTo('App\Letter', 'letter_id');
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
