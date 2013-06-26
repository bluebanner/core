<?php 

use Mockery as m;

class StorageTest extends TestCase
{
	
	public function tearDown()
	{
		m::close();
	}
	
	public function testCanCallFromApp()
	{
		Storage::locations();
	}
}
