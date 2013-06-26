<?php namespace Bluebanner\Core\Model;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Category extends Eloquent
{
	
	protected $table = 'core_item_category';
	
	protected $guarded = array('id');
	
	protected $softDelete = true;

}
