<?php namespace Bluebanner\Core\Model;

class Role extends BaseModel
{
	
	protected $table = 'core_platform_role';
	
	protected $guarded = array('id');
	
	protected $softDelete = true;
	
	public $rules = array();
}