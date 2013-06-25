<?php

use Mockery as m;

use Bluebanner\Core\ItemService;

class ItemTest extends TestCase
{
	
	protected $sku = '100-000-01';
	protected $skuArray = array('sku' => '100-000-01', 'category_id' => 1);
	
	protected $sku_1 = '100-000-02';
	protected $skuArray_1 = array('sku' => '100-000-02', 'category_id' => 1);
	
	public function setUp()
	{
		parent::setUp();
		Bluebanner\Core\Model\Item::truncate();
	}
	
	public function tearDown()
	{
		m::close();
	}
	
	/**
	 * @expectedException Bluebanner\Core\Exception\ItemDuplicateException
	 */
	public function testItemCRUDRun()
	{
		$sku = $this->sku;
		$skuArray = $this->skuArray;
		
		$service = $this->getItemService();
		
		$this->assertEquals(false, $service->exists($sku));
		$this->assertEquals(0, $service->itemRemove($sku));
		$this->assertInstanceOf('Bluebanner\Core\Model\Item', $service->itemCreate($skuArray));
		$this->assertEquals(true, $service->exists($sku));
		
		// throw ItemDuplicateException
		$service->itemCreate($skuArray);
		
		$this->assertEquals(1, $service->itemRemove($sku));
		$this->assertEquals(false, $service->exists($sku));
	}
	
	public function testCanFinding()
	{
		$item = $this->getItemService()->itemCreate($this->skuArray);
		$this->assertEquals($this->sku, $item->sku);
		$this->assertEquals(1, $item->category->id);
		
		$result = $this->getItemService()->find($item->id);
		$this->assertEquals($this->sku, $result->sku);
		$this->assertEquals(1, $result->category->id);
		
		$anotherResult = $this->getItemService()->findBySku($this->sku);
		$this->assertEquals($this->sku, $anotherResult->sku);
		$this->assertEquals(1, $anotherResult->category->id);
	}
	
	public function testCanListing()
	{
		$item = $this->getItemService()->itemCreate($this->skuArray);
		$item1 = $this->getItemService()->itemCreate($this->skuArray_1);
	}

	
	protected function getItemService()
	{
		return new ItemService();
	}
}
