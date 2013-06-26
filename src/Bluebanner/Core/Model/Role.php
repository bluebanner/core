<?php namespace Bluebanner\Core\Model;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Role extends Eloquent
{
	
	protected $table = 'core_platform_role';
	
	protected $guarded = array('id');
	
	protected $softDelete = true;
}