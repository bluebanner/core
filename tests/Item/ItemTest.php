<?php

use Mockery as m;

class ItemTest extends TestCase
{
	
	protected $sku = '100-000-01';
	protected $skuArray = array('sku' => '100-000-01', 'category_id' => 1, 'active' => 1);
	
	protected $sku_1 = '100-000-02';
	protected $skuArray_1 = array('sku' => '100-000-02', 'category_id' => 1, 'active' => 1);
	
	private $service;
	
	public function setUp()
	{
		parent::setUp();
		Bluebanner\Core\Model\Category::create(array('name' => 'testing name'));
	}
	
	public function tearDown()
	{
		Bluebanner\Core\Model\Item::truncate();
		Bluebanner\Core\Model\Category::truncate();
		m::close();
	}
	
	/**
	 * @expectedException Bluebanner\Core\ItemDuplicateException
	 */
	public function testItemCRUDRun()
	{
		$sku = $this->sku;
		$skuArray = $this->skuArray;
		
		$this->assertEquals(false, Item::exists($sku));
		$this->assertEquals(0, Item::itemRemove($sku));
		$this->assertInstanceOf('Bluebanner\Core\Model\Item', Item::itemCreate($skuArray));
		$this->assertEquals(true, Item::exists($sku));
		
		$this->assertEquals(1, Item::itemRemove($sku));
		$this->assertEquals(false, Item::exists($sku));
		
		// throw ItemDuplicateException
		Item::itemCreate($skuArray);
	}
	
	public function testCanFinding()
	{
		$item = Item::itemCreate($this->skuArray);
		$this->assertEquals($this->sku, $item->sku);
		$this->assertEquals(1, $item->category->id);
		
		$result = Item::find($item->id);
		$this->assertEquals($this->sku, $result->sku);
		$this->assertEquals(1, $result->category->id);
		
		$anotherResult = Item::findBySku($this->sku);
		$this->assertEquals($this->sku, $anotherResult->sku);
		$this->assertEquals(1, $anotherResult->category->id);
	}
	
	public function testCanListing()
	{
		Item::itemCreate($this->skuArray);
		Item::itemCreate($this->skuArray_1);
		
		$items = Item::all()->get();
		
		$this->assertEquals(2, count($items));
		$this->assertEquals(2, count(Item::allByCategory(1)->get()));
		$this->assertEquals(0, count(Item::allByCategory(2)->get()));
	}
	

	public function testCanModify()
	{
		$item = Item::itemCreate($this->skuArray);
		$this->assertInstanceOf('Bluebanner\Core\Model\Item', Item::findBySku($this->sku));
		
		Item::itemUpdate(array_merge(array('id' => $item->id), $this->skuArray_1));

		$this->assertEquals('', Item::findBySku($this->sku));
		$this->assertInstanceOf('Bluebanner\Core\Model\Item', Item::findBySku($this->sku_1));
	}
	
	/**
	 * @expectedException Bluebanner\Core\ItemArgumentsException
	 */
	public function testModifyThrowNonId()
	{
		Item::itemUpdate($this->skuArray);
	}
	
	/**
	 * @expectedException Bluebanner\Core\ItemNotFoundException
	 */
	public function testModifyThrowNotFound()
	{
		Item::itemUpdate(array_merge(array('id' => 1), $this->skuArray));
	}
	
	/**
	 * @expectedException Bluebanner\Core\ItemDuplicateException
	 */
	public function testModifyThrowDuplicate()
	{
		Item::itemCreate($this->skuArray);
		Item::itemCreate($this->skuArray_1);
		Item::itemUpdate(array_merge(array('id' => 1), $this->skuArray_1));
	}
	
	public function testCanRemove()
	{
		Event::shouldReceive('fire')->once()->with('item.create', $this->skuArray);
		Event::shouldReceive('fire')->once()->with('item.remove', $this->sku);
		
		$item = Item::itemCreate($this->skuArray);
		Item::itemRemove($this->sku);
	}
	
	public function testCategoryCanCreate()
	{
		$cate = Item::categoryCreate('testing name1');
		$this->assertInstanceOf('Bluebanner\Core\Model\Category', $cate);
	}
	
	public function testCategoryCanRemove()
	{
		$this->assertEquals(true, Item::categoryRemove(1));
	}
	
	/**
	 * @expectedException Bluebanner\Core\ItemNotFoundException
	 */
	public function testCategoryCanCreateThrowNotFound($value='')
	{
		$this->assertEquals(true, Item::categoryRemove(100));
	}
	
	/**
	 * @expectedException Bluebanner\Core\ItemDuplicateException
	 */
	public function testCategoryCanCreateThrowDuplicate()
	{
		$cate = Item::categoryCreate('testing name');
	}

}
