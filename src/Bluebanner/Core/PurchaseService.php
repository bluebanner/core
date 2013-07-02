<?php namespace Bluebanner\Core;

use Bluebanner\Core\Model\Vendor;
use Bluebanner\Core\Model\VendorQuotation;
use Bluebanner\Core\Model\PurchaseRequest;
use Bluebanner\Core\Model\PurchaseRequestDetail;
use Bluebanner\Core\Model\User;
use Bluebanner\Core\Model\Item;

use Bluebanner\Core\Purchase\POStatus;
use Bluebanner\Core\Purchase\PRStatus;
use Bluebanner\Core\Purchase\PRType;

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
	
	public function vendorQuotationNew($array)
	{
		if ( ! array_key_exists('vendor_id', $array) || ! array_key_exists('item_id', $array))
			throw new PurchaseArgumentsException('vendor and item were both required to create a quotation');
			
		if ( ! Vendor::find($array['vendor_id']) || ! Item::find($array['item_id']))
			throw new PurchaseArgumentsException('vendor or item can not found');
			
		return VendorQuotation::create($array);
	}
	
	public function vendorQuotationUpdate($array)
	{
		if ( ! array_key_exists('id', $array) || ! $quotation = VendorQuotation::find($array['id']))
			throw new VendorNotFoundException("quotation [{$array['id']}] not found");
			
		if ( ! Vendor::find($array['vendor_id']) || ! Item::find($array['item_id']))
			throw new PurchaseArgumentsException('vendor or item can not found');
			
		return $quotation->update($array);
	}
	
	public function vendorQuotationRemove($id)
	{
		if ( ! $quotation = VendorQuotation::find($id))
			throw new PurchaseArgumentsException("quotation [{$id}] for delete not found");
			
		return $quotation->delete();
	}
	
	/**
	 * create new PR
	 * 
	 * @param	int $agent
	 * @param string $invoice
	 * @return Bluebanner\Core\Model\PurchaseRequest
	 */
	public function purchaseRequestNew($agent, $invoice)
	{
		
		if (is_null($agent) || is_null($invoice))
			throw new PurchaseArgumentsException('invalid agent or invoice');
			
		if ( ! User::find($agent))
			throw new PurchaseArgumentsException("invalid agent [{$agent}]");
			
		if (PurchaseRequest::where('invoice', '=', $invoice)->count())
			throw new PurchaseDuplicateException("duplicate invoice [$invoice]");
			
		return PurchaseRequest::create(array(
			'agent'	=> $agent,
			'invoice' => $invoice,
			'status' => PRStatus::PENDING,
			'type' => PRType::ORDER
		));
	}
	
	public function purchaseRequestList()
	{
		return PurchaseRequest::all();
	}
	
	public function purchaseRequestFind($id)
	{
		return PurchaseRequest::find($id);
	}
	
	public function purchaseRequestFindByInvoice($invoice)
	{
		return PurchaseRequest::where('invoice', '=', $invoice)->first();
	}
	
	public function purchaseRequestDetailNew($id, $wh_id, $item_id, $vendor_id, $qty, $including_tax, $transportation)
	{
		if ( ! $pr = PurchaseRequest::find($id))
			throw new PurchaseArgumentsException("PR [{$id}] can not found");
			
		// some validations
		
		return PurchaseRequestDetail::create(array(
			'warehouse_id' => 1,
			'request_id' => $id,
			'item_id' => $item_id,
			'vendor_id' => $vendor_id,
			'qty' => $qty,
			'including_tax' => $including_tax,
			'transportation' => $transportation,
		));

	}
	
	public function purchaseRequestDetailUpdate($array)
	{
		if ( ! array_key_exists('id', $array) || ! $pr = PurchaseRequestDetail::find($array['id']))
			throw new PurchaseArgumentsException("PR Detail [{$array['id']}] can not found");
			
		return $pr->update($array);
	}
	
	public function purchaseRequestDetailRemove($id)
	{
		if ( ! $detail=PurchaseRequestDetail::find($id))
			throw new PurchaseArgumentsException("PR Detail [{$id}] can not found");
			
		return $detail->delete();
	}
	
}
