<?php

use Mockery as m;

class ItemTest extends PHPUnit_Framework_TestCase
{
	
	public function tearDown()
	{
		m::close();
	}
	
	public function testItemCanAdd()
	{
		$item = $this->getItem();
	}
	
	protected function getItem()
	{
		return new Bluebanner\Core\Model\Item;
	}
}
