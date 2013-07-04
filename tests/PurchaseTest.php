<?php 

use Mockery as m;

class PurchaseTest extends TestCase
{
	public function tearDown()
	{
		Bluebanner\Core\Model\PurchaseRequestDetail::truncate();
		Bluebanner\Core\Model\PurchaseRequest::truncate();
		Bluebanner\Core\Model\Vendor::truncate();
		
		Bluebanner\Core\Model\Item::truncate();
		Bluebanner\Core\Model\Category::truncate();
		Bluebanner\Core\Model\Warehouse::truncate();
		m::close();
	}

	
	
	public function testPurchaseRequest()
	{
		Bluebanner\Core\Model\Warehouse::create(array('name' => 'temp wh'));
		Bluebanner\Core\Model\Category::create(array('name' => 'temp'));
		Bluebanner\Core\Model\Item::create(array('sku'=>'11111', 'category_id' => 1));
		Bluebanner\Core\Model\Vendor::create(array('name' => 'vendor', 'code' => '001001001'));
		$this->assertInstanceOf('Bluebanner\Core\Model\PurchaseRequest', $pr = Purchase::purchaseRequestNew(1, '11110101010'));
		$this->assertInstanceOf('Bluebanner\Core\Model\PurchaseRequestDetail', Purchase::purchaseRequestDetailNew($pr->id, 1, 1, 1, 10, 0, 'surface'));
		
		$this->assertTrue(Purchase::purchaseRequestDetailUpdate(array('id' => '1', 'qty' => 20)));
		$this->assertEquals(20, Purchase::purchaseRequestFind(1)->details->first()->qty);
	}
}