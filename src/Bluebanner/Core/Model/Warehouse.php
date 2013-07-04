<?php namespace Bluebanner\Core\Model;

class Warehouse extends BaseModel
{
	
	protected $table = 'core_storage_warehouse';
	
	protected $guarded = array('id');
	
	protected $softDelete = true;
	
	public $rules = array();
	
}