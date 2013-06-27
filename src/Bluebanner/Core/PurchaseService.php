<?php namespace Bluebanner\Core;

use Bluebanner\Core\Model\Vendor;
use Bluebanner\Core\Model\PurchaseRequest;

class PurchaseArgumentsException extends \Exception {}

class PurchaseService
{
	
	public function vendorList()
	{
		return Vendor::all();
	}
	
	public function PurchaseRequestStart()
	{
		// PurchaseRequest::create(array());
	}
	
}
