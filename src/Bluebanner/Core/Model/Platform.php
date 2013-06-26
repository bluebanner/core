<?php namespace Bluebanner\Core\Model;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Platform extends Eloquent
{
	
	protected $table = 'core_platform_master';
	
	protected $guarded = array('id');
	
	protected $softDelete = true;
}