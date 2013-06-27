<?php namespace Bluebanner\Core;

use Illuminate\Support\Facades\Event;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Bluebanner\Core\Model\Item;
use Bluebanner\Core\Model\Category;

class ItemCategoryException extends \Exception {}
class ItemNotFoundException extends \Exception {}
class ItemDuplicateException extends \Exception {}
class ItemArgumentsException extends \Exception {}

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
		return Item::active();
	}
	
	public function allByCategory($cid)
	{
		return Item::where('category_id', '=', $cid);
	}

	/**
	 * 创建SKU
	 */
	public function itemCreate($array)
	{
		Event::fire('item.create', $array);

		if ( ! array_key_exists('sku', $array) || ! array_key_exists('category_id', $array))
			throw new ItemArgumentsException('SKU and category_id are both required!');

		if (Item::withTrashed()->where('sku', '=', $array['sku'])->count())
			throw new ItemDuplicateException("try to add an existed SKU {$array['sku']}!");
		
		return Item::create($array);
	}
	
	public function itemUpdate($array)
	{
		Event::fire('item.update', $array);
		
		if ( ! array_key_exists('id', $array))
			throw new ItemArgumentsException("the attribute ID should in array for update");
		
		if ( ! $item = Item::find($array['id']))
			throw new ItemNotFoundException("can not found the item by ID[{$array['id']}]");
			
		if (array_key_exists('sku', $array) && $item->sku ! = $array['sku'] && Item::withTrashed()->where('sku', '=', $array['sku'])->count())
			throw new ItemDuplicateException("try to change the attribute SKU to an existed SKU {$array['sku']}");
		
		$item->update($array);
	}
	
	/**
	 * Delete Item
	 * @todo need more validations
	 * @return int affected Rows
	 */
	public function itemRemove($sku)
	{
		Event::fire('item.remove', $sku);
		
		return Item::where('sku', '=', $sku)->delete();
	}
	
	// Category
	public function categoryCreate($name)
	{
		Event::fire('item.category.create');
		
		if (Category::withTrashed()->where('name', '=', $name)->count())
			throw new ItemDuplicateException("Category Name '{$name}' existed");
			
		return Category::create(array('name' => $name));
	}

	public function categoryRemove($cid)
	{
		Event::fire('item.category.remove');
		
		if (Item::where('category_id', '=', $cid)->count())
			throw new ItemCategoryException('make sure the item list of this cate was empty');
			
		if ( ! $item = Category::find($cid))
			throw new ItemNotFoundException("can not found the category '{$cid}'!");
			
		return $item->delete();
	}

}
