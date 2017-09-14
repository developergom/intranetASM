<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PO extends Model
{
    protected $table = 'po';
	protected $primaryKey = 'po_id';

	protected $fillable = [
				'po_date', 
				'po_no',
				'po_amount',
				'po_remarks',
				'updated_at',
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by'
	];
}
