<?php namespace Bluebanner\Core;

use Bluebanner\Core\Model\Vendor;
use Bluebanner\Core\Model\PurchaseRequest;

class VendorNotFoundException extends \Exception {}
class PurchaseArgumentsException extends \Exception {}
class PurchaseDuplicateException extends \Exception {}

class PurchaseService
{
	
	public function vendorList()
	{
		return Vendor::all();
	}
	
	public function vendorListByName($name)
	{
		return Vendor::where('name', 'like', "%$name%");
	}
	
	public function vendorListByCode($code)
	{
		return Vendor::where('code', 'like', "%$code%");
	}
	
	public function vendorListByCategory($category_id)
	{
		return Vendor::where('category_id', '=', $category_id);
	}
	
	public function vendorFind($id)
	{
		return Vendor::find($id);
	}
	
	public function vendorFindByCode($code)
	{
		return Vendor::where('code', '=', $code)->first();
	}
	
	public function vendorNew($array)
	{
		if (Vendor::withTrashed()->where('code', '=', $array['code'])->count())
			throw new PurchaseDuplicateException("Duplicated Vendor Code {$array['code']}");
			
		if (Vendor::withTrashed()->where('name', '=', $array['name'])->count())
			throw new PurchaseDuplicateException("Duplicated Vendor Name {$array['name']}");
		
		return Vendor::create($array);
	}
	
	public function vendorUpdate($array)
	{
		if (! array_key_exists('id', $array) || ! $vendor = Vendor::find($array['id']))
			throw new VendorNotFoundException;
			
		if (array_key_exists('name', $array) && $vendor->name != $array['name'] && Vendor::withTrashed()->where('name', '=', $array['name'])->count())
			throw new PurchaseDuplicateException("Duplicated Vendor Name {$array['name']}");
			
		if (array_key_exists('code', $array) && $vendor->code != $array['code'] && Vendor::withTrashed()->where('code', '=', $array['code'])->count())
			throw new PurchaseDuplicateException("Duplicated Vendor Code {$array['code']}");
			
		return $vendor->update($array);
	}
	
	public function vendorRemove($id)
	{
		if ( ! $vendor = Vendor::find($id))
			throw new VendorNotFoundException;
			
		return $vendor->delete();
	}
	
	public function PurchaseRequestStart()
	{
		// PurchaseRequest::create(array());
	}
	
}
