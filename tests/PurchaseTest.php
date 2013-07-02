<?php 

use Mockery as m;

class PurchaseTest extends TestCase
{
	public function tearDown()
	{
		Bluebanner\Core\Model\PurchaseRequestDetail::truncate();
		Bluebanner\Core\Model\PurchaseRequest::truncate();
		
		Bluebanner\Core\Model\VendorQuotation::truncate();
		Bluebanner\Core\Model\Vendor::truncate();

		Bluebanner\Core\Model\Item::truncate();
		Bluebanner\Core\Model\Category::truncate();
		Bluebanner\Core\Model\Warehouse::truncate();
		m::close();
	}

	public function testVendorCRUD()
	{
		$this->assertEquals(0, Purchase::vendorList()->count());
		
		$this->assertInstanceOf('Bluebanner\Core\Model\Vendor', $vendor = Purchase::vendorNew(array('name' => 'vendor', 'code' => '001001001')));
		$this->assertEquals('vendor', $vendor->name);
		$this->assertEquals('001001001', $vendor->code);
		
		$this->assertEquals(1, Purchase::vendorList()->count());
		$this->assertEquals(1, Purchase::vendorListByName($vendor->name)->count());
		$this->assertEquals(1, Purchase::vendorListByCode($vendor->code)->count());
		$this->assertEquals(0, Purchase::vendorListByCategory(1)->count());
		$this->assertInstanceOf('Bluebanner\Core\Model\Vendor', Purchase::vendorFind($vendor->id));
		$this->assertInstanceOf('Bluebanner\Core\Model\Vendor', Purchase::vendorFindByCode($vendor->code));
		
		$this->assertTrue(Purchase::vendorUpdate(array('id' => $vendor->id, 'name' => 'xxx')));
		
		$this->assertTrue(Purchase::vendorRemove($vendor->id));
		$this->assertEquals(0, Purchase::vendorList()->count());
	}
	
	/**
	 * @expectedException Bluebanner\Core\VendorNotFoundException
	 */
	public function testVendorUpdateNotFound()
	{
		$this->assertInstanceOf('Bluebanner\Core\Model\Vendor', $vendor = Purchase::vendorNew(array('name' => 'vendor', 'code' => '001001001')));
		Purchase::vendorUpdate(array('id' => 2, 'name' => 'what ever'));
	}
	
	/**
	 * @expectedException Bluebanner\Core\PurchaseDuplicateException
	 */
	public function testVendorUpdateNameDuplicate()
	{
		$this->assertInstanceOf('Bluebanner\Core\Model\Vendor', $vendor = Purchase::vendorNew(array('name' => 'vendor', 'code' => '001001001')));
		$this->assertInstanceOf('Bluebanner\Core\Model\Vendor', Purchase::vendorNew(array('name' => 'vendor2', 'code' => '001001002')));
		Purchase::vendorUpdate(array('id' => 1, 'name' => 'vendor2'));
	}
	
	/**
	 * @expectedException Bluebanner\Core\PurchaseDuplicateException
	 */
	public function testVendorUpdateCodeDuplicate()
	{
		$this->assertInstanceOf('Bluebanner\Core\Model\Vendor', $vendor = Purchase::vendorNew(array('name' => 'vendor', 'code' => '001001001')));
		$this->assertInstanceOf('Bluebanner\Core\Model\Vendor', Purchase::vendorNew(array('name' => 'vendor2', 'code' => '001001002')));
		Purchase::vendorUpdate(array('id' => 1, 'code' => '001001002'));
	}
	
	/**
	 * @expectedException Bluebanner\Core\VendorNotFoundException
	 */
	public function testVendorRemoveNotFound()
	{
		Purchase::vendorRemove(2);
	}
	
	/**
	 * @expectedException Bluebanner\Core\PurchaseArgumentsException
	 */
	public function testVendorQuotationNew()
	{
		Purchase::vendorQuotationNew(array('vendor_id' => 1, 'item_id' => 1));
	}
	
	/**
	 * @expectedException Bluebanner\Core\PurchaseArgumentsException
	 */
	public function testVendorQuotationUpdate()
	{
		Purchase::vendorQuotationNew(array('vendor_id' => 1, 'item_id' => 1));
	}
	
	/**
	 * @expectedException Bluebanner\Core\PurchaseArgumentsException
	 */
	public function testVendorQuotationRemoveNotFound()
	{
		Purchase::vendorQuotationRemove(1);
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