<?php namespace Bluebanner\Core\Model;

class Platform extends BaseModel
{
	
	protected $table = 'core_platform_master';
	
	protected $guarded = array('id');
	
	protected $softDelete = true;
	
	public $rules = array(
		'name' => 'required|unique:core_platform_master',
	);
}