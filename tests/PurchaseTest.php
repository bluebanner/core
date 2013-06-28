<?php 

use Mockery as m;

class PurchaseTest extends TestCase
{
	public function tearDown()
	{
		Bluebanner\Core\Model\Vendor::truncate();
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
}