<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    //
    protected $table = 'actions';
	protected $primaryKey = 'action_id';

	protected $fillable = [
				'action_name', 'action_alias', 'action_desc', 'active'
	];

	protected $hidden = [
				'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function modules() {
        return $this->belongsToMany('App\Module','actions_modules');
    }
}
