<?php 

use Mockery as m;

class VendorTest extends TestCase
{
	public function tearDown()
	{
		Bluebanner\Core\Model\VendorQuotation::truncate();
		Bluebanner\Core\Model\Vendor::truncate();
		m::close();
	}
	
	public function testVendorCRUD()
	{
		$model = new Bluebanner\Core\Model\Vendor(array('name' => 'vendor', 'code' => '001001001'));
		$this->assertTrue(Vendor::vendorNew($model));
		
		$this->assertEquals(1, Vendor::vendorList()->count());
		$this->assertEquals(1, Vendor::vendorListByName($model->name)->count());
		$this->assertEquals(1, Vendor::vendorListByCode($model->code)->count());
		$this->assertEquals(0, Vendor::vendorListByCategory(1)->count());

		$this->assertInstanceOf('Bluebanner\Core\Model\Vendor', Vendor::vendorFind($model->id));
		$this->assertInstanceOf('Bluebanner\Core\Model\Vendor', Vendor::vendorFindByCode($model->code));
		
		$this->assertTrue(Vendor::vendorUpdate(array('id' => $model->id, 'name' => 'xxx')));
		
		$this->assertTrue(Vendor::vendorRemove($model->id));
		$this->assertEquals(0, Vendor::vendorList()->count());
	}
	
	/**
	 * @expectedException Bluebanner\Core\VendorNotFoundException
	 */
	public function testVendorUpdateNotFound()
	{
		$model = new Bluebanner\Core\Model\Vendor(array('name' => 'vendor', 'code' => '001001001'));
		$this->assertTrue(Vendor::vendorNew($model));
		Vendor::vendorUpdate(array('id' => 2, 'name' => 'what ever'));
	}
	
	/**
	 * @expectedException Bluebanner\Core\VendorDuplicateException
	 */
	public function testVendorUpdateNameDuplicate()
	{
		$model = new Bluebanner\Core\Model\Vendor(array('name' => 'vendor', 'code' => '001001001'));
		$this->assertTrue(Vendor::vendorNew($model));
		
		$model1 = new Bluebanner\Core\Model\Vendor(array('name' => 'vendor2', 'code' => '001001002'));
		$this->assertTrue(Vendor::vendorNew($model1));
		Vendor::vendorUpdate(array('id' => 1, 'name' => 'vendor2'));
	}
	
	/**
	 * @expectedException Bluebanner\Core\VendorDuplicateException
	 */
	public function testVendorUpdateCodeDuplicate()
	{
		$model = new Bluebanner\Core\Model\Vendor(array('name' => 'vendor', 'code' => '001001001'));
		$this->assertTrue(Vendor::vendorNew($model));
		
		$model1 = new Bluebanner\Core\Model\Vendor(array('name' => 'vendor2', 'code' => '001001002'));
		$this->assertTrue(Vendor::vendorNew($model1));
		Vendor::vendorUpdate(array('id' => 1, 'code' => '001001002'));
	}
	
	/**
	 * @expectedException Bluebanner\Core\VendorNotFoundException
	 */
	public function testVendorRemoveNotFound()
	{
		Vendor::vendorRemove(2);
	}
	
	/**
	 * @expectedException Bluebanner\Core\VendorArgumentsException
	 */
	public function testVendorQuotationNew()
	{
		Vendor::vendorQuotationNew(array('vendor_id' => 1, 'item_id' => 1));
	}
	
	/**
	 * @expectedException Bluebanner\Core\VendorArgumentsException
	 */
	public function testVendorQuotationUpdate()
	{
		Vendor::vendorQuotationNew(array('vendor_id' => 1, 'item_id' => 1));
	}
	
	/**
	 * @expectedException Bluebanner\Core\VendorArgumentsException
	 */
	public function testVendorQuotationRemoveNotFound()
	{
		Vendor::vendorQuotationRemove(1);
	}
}