<?php namespace Bluebanner\Core\Model;

use Bluebanner\Core\Model\Category;

class Item extends BaseModel
{
	
	protected $table = 'core_item_master';
	
	protected $guarded = array('id');
	
	protected $softDelete = true;
	
	public $rules = array(
		'sku' => 'required|unique:core_item_master',
		'category_id' => 'required|integer|unique:core_item_master'
	);
	
	public function scopeActive($query)
	{
		return $query->where('active', '=', '1');
	}
	
	public function category()
	{
		return $this->belongsTo('Bluebanner\Core\Model\Category');
	}
}
