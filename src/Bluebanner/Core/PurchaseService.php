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

class PurchaseArgumentsException extends \Exception {}
class PurchaseDuplicateException extends \Exception {}

class PurchaseService
{
	
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
