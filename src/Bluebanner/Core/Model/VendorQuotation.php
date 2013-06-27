<?php namespace Bluebanner\Core\Model;

use Illuminate\Database\Eloquent\Model as Eloquent;

class VendorQuotation extends Eloquent
{
	
	protected $table = 'core_purchase_vendor_quotation';
	
	protected $guarded = array('id');
	
	protected $softDelete = true;
	
	public function vendor()
	{
		$this->belongsTo('Bluebanner\Core\Model\Vendor');
	}
	
	public function item()
	{
		$this->belongsTo('Bluebanner\Core\Model\Item');
	}
}