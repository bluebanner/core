<?php

use Mockery as m;

use Bluebanner\Core\ItemService;

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
		$this->service = $this->getItemService();
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
		
		$this->assertEquals(false, $this->service->exists($sku));
		$this->assertEquals(0, $this->service->itemRemove($sku));
		$this->assertInstanceOf('Bluebanner\Core\Model\Item', $this->service->itemCreate($skuArray));
		$this->assertEquals(true, $this->service->exists($sku));
		
		$this->assertEquals(1, $this->service->itemRemove($sku));
		$this->assertEquals(false, $this->service->exists($sku));
		
		// throw ItemDuplicateException
		$this->service->itemCreate($skuArray);
	}
	
	public function testCanFinding()
	{
		$item = $this->service->itemCreate($this->skuArray);
		$this->assertEquals($this->sku, $item->sku);
		$this->assertEquals(1, $item->category->id);
		
		$result = $this->service->find($item->id);
		$this->assertEquals($this->sku, $result->sku);
		$this->assertEquals(1, $result->category->id);
		
		$anotherResult = $this->service->findBySku($this->sku);
		$this->assertEquals($this->sku, $anotherResult->sku);
		$this->assertEquals(1, $anotherResult->category->id);
	}
	
	public function testCanListing()
	{
		$this->service->itemCreate($this->skuArray);
		$this->service->itemCreate($this->skuArray_1);
		
		$items = $this->service->all()->get();
		
		$this->assertEquals(2, count($items));
		$this->assertEquals(2, count($this->service->allByCategory(1)->get()));
		$this->assertEquals(0, count($this->service->allByCategory(2)->get()));
	}
	

	public function testCanModify()
	{
		$item = $this->service->itemCreate($this->skuArray);
		$this->assertInstanceOf('Bluebanner\Core\Model\Item', $this->service->findBySku($this->sku));
		
		$this->service->itemUpdate(array_merge(array('id' => $item->id), $this->skuArray_1));

		$this->assertEquals('', $this->service->findBySku($this->sku));
		$this->assertInstanceOf('Bluebanner\Core\Model\Item', $this->service->findBySku($this->sku_1));
	}
	
	/**
	 * @expectedException Bluebanner\Core\ItemArgumentsException
	 */
	public function testModifyThrowNonId()
	{
		$this->service->itemUpdate($this->skuArray);
	}
	
	/**
	 * @expectedException Bluebanner\Core\ItemNotFoundException
	 */
	public function testModifyThrowNotFound()
	{
		$this->service->itemUpdate(array_merge(array('id' => 1), $this->skuArray));
	}
	
	/**
	 * @expectedException Bluebanner\Core\ItemDuplicateException
	 */
	public function testModifyThrowDuplicate()
	{
		$this->service->itemCreate($this->skuArray);
		$this->service->itemCreate($this->skuArray_1);
		$this->service->itemUpdate(array_merge(array('id' => 1), $this->skuArray_1));
	}
	
	public function testCanRemove()
	{
		Event::shouldReceive('fire')->once()->with('item.create', $this->skuArray);
		Event::shouldReceive('fire')->once()->with('item.remove', $this->sku);
		
		$item = $this->service->itemCreate($this->skuArray);
		$this->service->itemRemove($this->sku);
	}
	
	public function testCategoryCanCreate()
	{
		$cate = $this->service->categoryCreate('testing name1');
		$this->assertInstanceOf('Bluebanner\Core\Model\Category', $cate);
	}
	
	public function testCategoryCanRemove()
	{
		$this->assertEquals(true, $this->service->categoryRemove(1));
	}
	
	/**
	 * @expectedException Bluebanner\Core\ItemNotFoundException
	 */
	public function testCategoryCanCreateThrowNotFound($value='')
	{
		$this->assertEquals(true, $this->service->categoryRemove(100));
	}
	
	/**
	 * @expectedException Bluebanner\Core\ItemDuplicateException
	 */
	public function testCategoryCanCreateThrowDuplicate()
	{
		$cate = $this->service->categoryCreate('testing name');
	}

	
	protected function getItemService()
	{
		return new ItemService();
	}
}
