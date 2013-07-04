<?php namespace Bluebanner\Core\Model;

class Account extends BaseModel
{
	
	protected $table = 'core_platform_account';
	
	protected $guarded = array('id');
	
	protected $softDelete = true;
	
	public $rules = array(
		'platform_id' => 'required|integer',
		'name' => 'required|unique:core_platform_account',
	);
	
	public function platform()
	{
		return $this->belongsTo('Bluebanner\Core\Model\Platform');
	}
}