<?php namespace Bluebanner\Core\Model;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Item extends Eloquent
{
	
	protected $table = 'core_item_master';
	
	public function scopeActive($query)
	{
		return $query->where('active', '=', '1');
	}
}
