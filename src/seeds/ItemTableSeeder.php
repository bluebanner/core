<?php namespace Bluebanner\Core;

use Illuminate\Database\Seeder;
use Bluebanner\Core\Model\Item;
use Bluebanner\Core\Model\Category;

class ItemTableSeeder extends Seeder
{
	
	public function run()
	{
		Item::truncate();
		Category::truncate();
		
		Category::create(array('name' => 'AC Adapter'));
		Category::create(array('name' => 'Optical Drive'));
		Category::create(array('name' => 'Networking'));
		Category::create(array('name' => 'Packing Material'));
		Category::create(array('name' => 'Cable'));
		Category::create(array('name' => 'Cellphone Accessories'));
		Category::create(array('name' => 'Test Instrument'));
		Category::create(array('name' => 'Pet Electronics'));
		Category::create(array('name' => 'Surveillance'));
		Category::create(array('name' => 'Video Game Accessories'));
		Category::create(array('name' => 'Car Electronics'));
		Category::create(array('name' => 'Tablet'));
		Category::create(array('name' => 'PC Accessories'));
		Category::create(array('name' => 'Antenna'));
		Category::create(array('name' => 'Home&Garden'));
		Category::create(array('name' => 'Stage&Home Theater Office'));
		Category::create(array('name' => 'LED Screen'));
		Category::create(array('name' => 'Hidden Camera'));

	}
}

