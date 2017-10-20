<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LetterType extends Model
{
    protected $table = 'letter_types';
	protected $primaryKey = 'letter_type_id';

	protected $fillable = [
				'letter_type_code', 'letter_type_name', 'letter_type_desc'
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function letters()
	{
		return $this->hasMany('App\Letter', 'letter_type_id');
	}
}
