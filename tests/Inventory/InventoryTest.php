<?php 

use Mockery as m;

class InventoryTest extends TestCase
{
	public function tearDown()
	{
		m::close();
	}
	
	public function testAssertTrue()
	{
		$this->assertTrue(true);
	}
}