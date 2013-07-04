<?php namespace Bluebanner\Core\Model;

class Vendor extends BaseModel
{
	
	protected $table = 'core_purchase_vendor';
	
	protected $guarded = array('id');
	
	protected $softDelete = true;
	
	public static $rules = array(
		'code' => 'required|unique:core_purchase_vendor'
	);
}