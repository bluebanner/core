<?php namespace Bluebanner\Core;

use Illuminate\Support\Facades\Event;
use Bluebanner\Core\Model\Item;

class ItemService
{
	
	public function exists($sku)
	{
		return Item::where('sku', $sku);
	}
	
	public function itemList()
	{
		return Item::active()->all();
	}
	
	public function itemCreate($array)
	{
		Event::fire('item:create', $array);
		
		Item::create($array);
	}
	
	protected function rules()
	{
		return array(
			'sku' => '',
			'category_id' => '',
		);
	}

}
