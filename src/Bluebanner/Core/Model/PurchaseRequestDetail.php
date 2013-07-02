<?php namespace Bluebanner\Core\Model;

use Illuminate\Database\Eloquent\Model as Eloquent;

class PurchaseRequestDetail extends Eloquent
{
	
	protected $touches = array('request');
	
	protected $table = 'core_purchase_request_detail';
	
	protected $guarded = array('id');
	
	protected $softDelete = true;
	
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