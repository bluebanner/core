<?php namespace Bluebanner\Core\Model;

class Category extends BaseModel
{
	
	protected $table = 'core_item_category';
	
	protected $guarded = array('id');
	
	protected $softDelete = true;
	
	public $rules = array(
		'name' => 'required|unique:core_item_category'
	);

}
