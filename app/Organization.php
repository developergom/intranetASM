<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $table = 'organizations';
	protected $primaryKey = 'organization_id';

	protected $fillable = [
				'organization_name',
				'organization_account_name',
				'organization_account_no',
				'organization_term_of_payment',
				'organization_desc',
				'updated_by'
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_at'
	];

	public function medias(){
		return $this->hasMany('App\Media', 'organization_id');
	}
}
