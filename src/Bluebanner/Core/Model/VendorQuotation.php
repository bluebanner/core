<?php namespace Bluebanner\Core\Model;

class VendorQuotation extends BaseModel
{
	
	protected $table = 'core_purchase_vendor_quotation';
	
	protected $guarded = array('id');
	
	protected $softDelete = true;
	
	public $rules = array(
		'vendor_id' => 'required|integer',
		'item_id' => 'required|integer'
	);
	
	public function vendor()
	{
		$this->belongsTo('Bluebanner\Core\Model\Vendor');
	}
	
	public function item()
	{
		$this->belongsTo('Bluebanner\Core\Model\Item');
	}
}