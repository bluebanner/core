<?php namespace Bluebanner\Core\Model;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Warehouse extends Eloquent
{
	
	protected $table = 'core_storage_warehouse';
	
	protected $guarded = array('id');
	
	protected $softDelete = true;
	
}