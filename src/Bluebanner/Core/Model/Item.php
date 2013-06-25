<?php namespace Bluebanner\Core\Model;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Bluebanner\Core\Model\Category;

class Item extends Eloquent
{
	
	protected $table = 'core_item_master';
	
	protected $softDelete = true;
	
	public function scopeActive($query)
	{
		return $query->where('active', '=', '1');
	}
	
	public function category()
	{
		return $this->belongsTo('Bluebanner\Core\Model\Category');
	}
}
