<?php namespace Bluebanner\Core;

use Bluebanner\Core\Model\Vendor;
use Bluebanner\Core\Model\VendorQuotation;
use Bluebanner\Core\Model\User;
use Bluebanner\Core\Model\Item;

class VendorNotFoundException extends \Exception {}
class VendorArgumentsException extends \Exception {}
class VendorDuplicateException extends \Exception {}

class VendorService
{
	
	protected $model;
	
	function __construct(Vendor $model = null)
	{
		$this->model = $model ?: with(new Vendor);
	}
	
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
	
	public function vendorNew(Vendor $model)
	{
		if ($model->withTrashed()->where('code', '=', $model->code)->count())
			throw new VendorDuplicateException("Duplicated Vendor Code {$model->code}");
			
		if ($model->withTrashed()->where('name', '=', $model->name)->count())
			throw new VendorDuplicateException("Duplicated Vendor Name {$model->name}");
		
		return $model->save();
	}
	
	public function vendorUpdate($array)
	{
		if (! array_key_exists('id', $array) || ! $vendor = Vendor::find($array['id']))
			throw new VendorNotFoundException;
			
		if (array_key_exists('name', $array) && $vendor->name != $array['name'] && Vendor::withTrashed()->where('name', '=', $array['name'])->count())
			throw new VendorDuplicateException("Duplicated Vendor Name {$array['name']}");
			
		if (array_key_exists('code', $array) && $vendor->code != $array['code'] && Vendor::withTrashed()->where('code', '=', $array['code'])->count())
			throw new VendorDuplicateException("Duplicated Vendor Code {$array['code']}");
			
		return $vendor->update($array);
	}
	
	public function vendorRemove($id)
	{
		if ( ! $vendor = Vendor::find($id))
			throw new VendorNotFoundException;
			
		return $vendor->delete();
	}
	
	public function vendorQuotationNew($array)
	{
		if ( ! array_key_exists('vendor_id', $array) || ! array_key_exists('item_id', $array))
			throw new VendorArgumentsException('vendor and item were both required to create a quotation');
			
		if ( ! Vendor::find($array['vendor_id']) || ! Item::find($array['item_id']))
			throw new VendorArgumentsException('vendor or item can not found');
			
		return VendorQuotation::create($array);
	}
	
	public function vendorQuotationUpdate($array)
	{
		if ( ! array_key_exists('id', $array) || ! $quotation = VendorQuotation::find($array['id']))
			throw new VendorNotFoundException("quotation [{$array['id']}] not found");
			
		if ( ! Vendor::find($array['vendor_id']) || ! Item::find($array['item_id']))
			throw new VendorArgumentsException('vendor or item can not found');
			
		return $quotation->update($array);
	}
	
	public function vendorQuotationRemove($id)
	{
		if ( ! $quotation = VendorQuotation::find($id))
			throw new VendorArgumentsException("quotation [{$id}] for delete not found");
			
		return $quotation->delete();
	}
}
