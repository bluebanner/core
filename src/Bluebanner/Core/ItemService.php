<?php namespace Bluebanner\Core;

use Illuminate\Support\Facades\Event;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Bluebanner\Core\Model\Item;
use Bluebanner\Core\Exception\ItemDuplicateException;

class ItemService
{
	
	/**
	 * 判断SKU是否存在
	 */
	public function exists($sku)
	{
		return Item::where('sku', '=', $sku)->count() === 1;
	}
	
	public function find($id)
	{
		return Item::find($id);
	}
	
	public function findBySku($sku)
	{
		return Item::where('sku', '=', $sku)->first();
	}
	
	
	/**
	 * SKU列表
	 */
	public function all()
	{
		return Item::active()->all();
	}
	
	public function allByCategory($cid)
	{
		return Item::where('category_id', '=', $cid)->all();
	}

	/**
	 * 创建SKU
	 */
	public function itemCreate($array)
	{
		Event::fire('item.create', $array);

		Eloquent::unguard();
		
		if (Item::withTrashed()->where('sku', '=', $array['sku'])->count())
			throw new ItemDuplicateException('try to add an existed SKU');
		
		return Item::create($array);
	}
	
	/**
	 * Delete Item
	 * 
	 * @return int affected Rows
	 */
	public function itemRemove($sku)
	{
		Event::fire('item.remove', $sku);
		
		return Item::where('sku', '=', $sku)->delete();
	}
	
	protected function rules()
	{
		return array(
			'sku' => '',
			'category_id' => '',
		);
	}

}
