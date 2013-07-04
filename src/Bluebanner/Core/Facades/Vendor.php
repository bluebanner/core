<?php namespace Bluebanner\Core\Facades;

use Illuminate\Support\Facades\Facade;

class Vendor extends Facade
{
	
	protected static function getFacadeAccessor()	{	return 'vendor';	}
	
}
