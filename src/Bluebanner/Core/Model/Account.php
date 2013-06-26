<?php namespace Bluebanner\Core\Model;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Account extends Eloquent
{
	
	protected $table = 'core_platform_account';
	
	protected $guarded = array('id');
	
	protected $softDelete = true;
	
	public function platform()
	{
		return $this->belongsTo('Bluebanner\Core\Model\Platform');
	}
}