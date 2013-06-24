<?php

use Mockery as m;

use Illuminate\Support\Facades\Event;
use Bluebanner\Core\ItemService;

class ItemTest extends TestCase
{
	
	public function tearDown()
	{
		m::close();
	}
	
	public function testItemitemCreateRun()
	{
		
		// $mock = m::mock('ItemService');
		// $mock->shouldReceive('exists')->once()->with('100-000-01')->andReturn(false);
		// $event = m::mock('Illuminate\Support\Facades\Event');
		// $event->shouldReceive('fire')->once()->with(array('sku' => '100-000-01'));
		
		$service = $this->getItemService();		
		$this->assertEquals(false, $service->itemCreate(array('sku' => '100-000-01')));

	}
	
	protected function getItemService()
	{
		return new ItemService();
	}
}
