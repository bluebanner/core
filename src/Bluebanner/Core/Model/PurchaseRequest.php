<?php namespace Bluebanner\Core\Model;

use Illuminate\Database\Eloquent\Model as Eloquent;

class PurchaseRequest extends Eloquent
{
	
	protected $table = 'core_purchase_request';
	
	protected $guarded = array('id');
	
	protected $softDelete = true;
}