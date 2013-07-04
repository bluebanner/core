<?php namespace Bluebanner\Core\Model;

class PurchaseRequest extends BaseModel
{
	
	protected $table = 'core_purchase_request';
	
	protected $guarded = array('id');
	
	protected $softDelete = true;
	
	public $rules = array(
		'invoice' => 'required|unique:core_purchase_request',
		'agent' => 'required|integer'
	);
	
	public function agent()
	{
		return $this->belongsTo('Bluebanner\Core\Model\User');
	}
	
	public function details()
	{
		return $this->hasMany('Bluebanner\Core\Model\PurchaseRequestDetail', 'request_id');
	}
}