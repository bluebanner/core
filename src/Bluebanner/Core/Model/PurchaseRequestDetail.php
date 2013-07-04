<?php namespace Bluebanner\Core\Model;

class PurchaseRequestDetail extends BaseModel
{
	
	protected $touches = array('request');
	
	protected $table = 'core_purchase_request_detail';
	
	protected $guarded = array('id');
	
	protected $softDelete = true;
	
	public $rules = array(
		'warehouse_id' => 'required|integer',
		'request_id' => 'required|integer',
		'item_id' => 'required|integer',
		'vendor_id' => 'required|integer',
	);
	
	public function warehouse()
	{
		# code...
	}
	
	public function request()
	{
		return $this->belongsTo('Bluebanner\Core\Model\PurchaseRequest');
	}
	
	public function item()
	{
		return $this->belongsTo('Bluebanner\Core\Model\Item');
	}
	
	public function vendor()
	{
		return $this->belongsTo('Bluebanner\Core\Model\Vendor');
	}
}