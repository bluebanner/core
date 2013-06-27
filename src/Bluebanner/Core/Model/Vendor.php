<?php namespace Bluebanner\Core\Model;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Vendor extends Eloquent
{
	
	protected $table = 'core_purchase_vendor';
	
	protected $guarded = array('id');
	
	protected $softDelete = true;
}