<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Letter extends Model
{
    protected $table = 'letters';
	protected $primaryKey = 'letter_id';

	protected $fillable = [
				'param_no',
				'letter_type_id', 
				'letter_no',
				'letter_to',
				'letter_notes',
				'letter_source',
				'revision_no',
				'current_user',
				'flow_no',
				'pic',
				'updated_at',
				'created_at'
	];

	protected $hidden = [
				'active', 'created_by', 'updated_by'
	];

	public function lettertype()
	{
		return $this->belongsTo('App\LetterType', 'letter_type_id');
	}

	public function letterhistories()
	{
		return $this->hasMany('App\LetterHistory', 'letter_id');
	}

	public function uploadfiles()
	{
		return $this->belongsToMany('App\UploadFile', 'letter_upload_file');
	}

	public function contracts()
	{
		return $this->belongsToMany('App\Contract', 'letters_contracts');
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
